include remi
include php
include apache

package { "git":
  ensure => present,
}

file { "/var/www":
  ensure => directory,
  owner => "apache",
  group => "apache",
  mode => 0755,
}

file{ "/var/www/sites":
  ensure => directory,
  owner => "apache",
  group => "apache",
  mode => 0755,
}


file { "/var/www/sites/php_test":
  ensure => link,
  target => "/vagrant",
}

file { "/etc/php.ini":
  ensure => present,
  source => "puppet:///modules/core/php.ini",
  owner => "root",
  group => "root",
  mode => 0644,
}

package{ "php-pear":
  ensure => present,
  require => Class[php],
}

exec{ "pear-autodiscover":
  command => "pear config-set auto_discover 1",
  require => Package[php-pear],
  path => $path,
}

exec{ "install-phpunit":
  command => "pear install pear.phpunit.de/PHPUnit",
  require => [Exec[pear-autodiscover],Package[php-pear]],
  path => $path,
}

Class[remi] -> Class[php] -> File["/etc/php.ini"]
