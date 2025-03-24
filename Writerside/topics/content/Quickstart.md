# Quickstart

<secondary-label ref="1.0.0" />

This is a quick way to start using the %project% in your project.
{id="summary"}

## Before you start

> You need to have `Symfony maker` and `IDMarinas maker` installed to be able to use the following commands.
> {style="warning"}

```console
composer require --dev symfony/maker-bundle
composer require --dev idmarinas/maker-bundle
```

## Install

```console
php bin/symfony make:idm:settings:bundle
```

<procedure title="These files are installed in the default folders" id="maker">
	<step>The Doctrine entities and repositories</step>
	<step>The administration controllers for EasyCorp EasyAdmin</step>
	<p>Congratulation! you have installed %project%.</p>
</procedure>

<seealso>
	<category ref="related">
		<a href="Installation.md" />
		<a href="Configuration.md" />
	</category>
</seealso>
