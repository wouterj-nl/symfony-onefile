Symfony One File Challenge 2024
===============================

How much code do we need for a functional Symfony application, without
resorting to code golf and unreadable code? That's the main challenge that
started this repository.

Fabien Potencier [blogged][blog] about a challenge he set for himself to
get it down to one file and 200 lines of code in 2013. Unfortunately, we
never got the final result. Now, 10+ years later, can we finish this
challenge?

[blog]: https://fabien.potencier.org/packing-a-symfony-full-stack-framework-application-in-one-file-introduction.html

The answer is: Yes and no! This project has exactly 200 lines of code, but
I didn't manage to get everything in one file. On the upside, this project
features a styled and dynamic todo-list application.

Some notable changes since Fabien posted his blog post:

* The [`MicroKernelTrait`][microkerneltrait], used in all Symfony kernels
  since 3.4, allows you to configure routes and services from inside the
  Kernel class. Evenmore: you can make any method a controller in the micro
  kernel class using the `#[Route]` attribute.
* Using Symfony Flex and the minimal skeleton, we didn't have to remove
  many files to reduce the application's size. Instead of removing what we
  don't want, we only install what we want.
* [Symfony UX][ux] gives us a smooth modern website without much code. Live
  components let us define actions (add, delete) and are called using AJAX
  calls by the code provided by Symfony and Stimulus.
* Modern PHP allows more expressive code without being verbose, e.g. by
  using features like [property types][types], [constructor property
  promotion][cpp] and [attributes][attributes].
* Symfony comes with lots of practical default config. I could remove most
  of the config without impacting this application too much, although it's
  no longer optimal for production use-cases (e.g. no Doctrine cache).

[microkerneltrait]: https://symfony.com/doc/current/configuration/micro_kernel_trait.html
[ux]: https://ux.symfony.com
[types]: https://www.php.net/manual/en/language.oop5.properties.php#language.oop5.properties.typed-properties
[cpp]: https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion
[attributes]: https://www.php.net/manual/en/language.attributes.overview.php

Can We Do Better?
-----------------

See something we can improve on? Send a contribution to this project or
Symfony. Let's see if we can make Symfony even more powerful!

But please remember, this project isn't meant to code golf our way to the
least characters. I know there is lots of whitespace I can remove to bring
us to less lines, but I want to keep this project realistic.
