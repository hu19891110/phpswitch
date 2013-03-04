Feature: phar:build
  Scenario:
    Given I run "PHPSWITCH_PREFIX=../prefix PHPSWITCH_HOME=../home ../../bin/phpswitch phar:build"
     Then The file "sandbox/phpswitch.phar" should exist

    Given I run "php phpswitch.phar"
     Then I should see
        """
        phpswitch version 0.1

        Usage:
         [options] command [arguments]

        Options:
         --help           -h Display this help message.
         --quiet          -q Do not output any message.
         --verbose        -v Increase verbosity of messages.
         --version        -V Display this application version.
         --ansi             Force ANSI output.
         --no-ansi          Disable ANSI output.
         --no-interaction -n Do not ask any interactive question.

        Available commands:
         help              Displays help for a command
         init              Initializes PhpSwitch environment
         list              Lists commands
        php
         php:config        Get or set configuration
         php:current       Displays current PHP version
         php:doc:install   Installs PHP offline documentation
         php:install       Installs a PHP version
         php:list          Lists PHP versions
         php:switch        Switch PHP version
         php:uninstall     Uninstalls a PHP version

        """
      And The command should exit with success status

    Given I run "php phpswitch.phar init"
     Then I should see
        """
        Directory ./.phpswitch was created
        Directory ./.phpswitch/downloads was created
        Directory ./.phpswitch/sources was created
        Directory ./.phpswitch/installed was created
        Directory ./.phpswitch/doc was created
        You should source ./.phpswitch/.phpswitchrc to use phpswitch

        """
      And The directory "sandbox/.phpswitch" should exist
      And The directory "sandbox/.phpswitch/downloads" should exist
      And The directory "sandbox/.phpswitch/sources" should exist
      And The directory "sandbox/.phpswitch/installed" should exist
      And The directory "sandbox/.phpswitch/doc" should exist
      And The file "sandbox/.phpswitch/.phpswitchrc" should exist
      And The command should exit with success status

