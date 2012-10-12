# How to contribute

1. Submit a new ticket for your issue.
2. Fork the repository on GitHub.
3. Create a topic branch from where you want to base your work.
  - To fix a bug in **production**, this is the *master* branch.
  - To help with the **redesign project**, this is the *redesign* branch.
  - Please avoid working directly on the *master* and the *redesign* branch, except for quick fixes.
  - To quickly create a topic branch based on *master*: `git checkout master` then `git checkout -b topic_branch`

## Tips

  - Make commits of logical units.
  - Do not edit files on the GitHub website.
  - Do not merge pull requests on the GitHub website.
  - Check for unnecessary whitespaces with git diff --check before committing.
  - Make sure your commit messages are in the proper format and in english.
  - Do not care too much about these rules: an organized project is nice, but well-written code is better.

## Syntax

  - Two spaces for JS, CSS, Stylus, and (pure) PHP files
  - One tab for HTML and (mixed) PHP/HTML files
  - No trailing whitespace.
  - Blank lines should not have any space.

(This document is vastly inspired by the CONTRIBUTING files of [Puppet](https://github.com/puppetlabs/puppet/blob/master/CONTRIBUTING.md) and [factory_girl](https://github.com/thoughtbot/factory_girl_rails/blob/master/CONTRIBUTING.md): thank you.)
