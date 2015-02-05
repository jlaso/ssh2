[![License](https://poser.pugx.org/jlaso/ssh2/license.svg)](https://packagist.org/packages/jlaso/ssh2)
[![Latest Unstable Version](https://poser.pugx.org/jlaso/ssh2/v/unstable.svg)](https://packagist.org/packages/jlaso/ssh2)
[![Total Downloads](https://poser.pugx.org/jlaso/ssh2/downloads.svg)](https://packagist.org/packages/jlaso/ssh2)
[![Latest Stable Version](https://poser.pugx.org/jlaso/ssh2/v/stable.svg)](https://packagist.org/packages/jlaso/ssh2)

## SSH2

This is a little wrapper to automate task in remote servers

with this package you can install, backup or do anything you want via ssh commands


### You need to install ssh2 support for PHP

http://php.net/manual/en/book.ssh2.php

## In OSX for me was useful this guide:
https://abendstille.at/blog/?p=144

## You can test or run locally with the ansible recipe to start a VirtualMachine

once composer launched move to vendor/jlaso/ss2h/

and start machine with vagrant up

obviously you need to have installed vagrant and ansible in your system

Once into the virtualmachine (with vagrant ssh) move to /vagrant and run composer install

Then you can run the demo with php demo.php

---

You can run the demo also in your local machine if you have support for php-ssh2

## demo

Servers declaration:
see servers.ini.dist and copy or rename to servers.ini

Tasks automation
see commands.ini.dist and copy or rename to commands.ini