#!/usr/bin/env php
<?php

function supportsAnsi(): bool
{
    if (getenv('NO_COLOR') !== false) {
        return false;
    }

    if (PHP_OS_FAMILY === 'Windows') {
        return (function_exists('sapi_windows_vt100_support')
            && sapi_windows_vt100_support(STDOUT))
            || getenv('ANSICON') !== false
            || getenv('ConEmuANSI') === 'ON'
            || str_starts_with((string) getenv('TERM'), 'xterm');
    }

    return stream_isatty(STDOUT);
}

function ansi(string $text, string $code): string
{
    if (! supportsAnsi()) {
        return $text;
    }

    return "\033[{$code}m{$text}\033[0m";
}

function bold(string $text): string
{
    return ansi($text, '1');
}

function dim(string $text): string
{
    return ansi($text, '2');
}

function green(string $text): string
{
    return ansi($text, '32');
}

function yellow(string $text): string
{
    return ansi($text, '33');
}

function writeln(string $line): void
{
    echo $line.PHP_EOL;
}

function ask(string $question, string $default = ''): string
{
    $prompt = bold($question);

    if ($default) {
        $prompt .= ' '.dim("({$default})");
    }

    $answer = readline('  '.$prompt.': ');

    if (! $answer) {
        return $default;
    }

    return $answer;
}

function run(string $command): string
{
    return trim((string) shell_exec($command));
}

function str_after(string $subject, string $search): string
{
    $pos = strrpos($subject, $search);

    if ($pos === false) {
        return $subject;
    }

    return substr($subject, $pos + strlen($search));
}

function slugify(string $subject): string
{
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $subject), '-'));
}

function title_case(string $subject): string
{
    return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $subject)));
}

function title_snake(string $subject, string $replace = '_'): string
{
    return str_replace(['-', '_'], $replace, $subject);
}

function replace_in_file(string $file, array $replacements): void
{
    $contents = file_get_contents($file);

    file_put_contents(
        $file,
        str_replace(
            array_keys($replacements),
            array_values($replacements),
            $contents
        )
    );
}

function remove_prefix(string $prefix, string $content): string
{
    if (str_starts_with($content, $prefix)) {
        return substr($content, strlen($prefix));
    }

    return $content;
}

function remove_readme_paragraphs(string $file): void
{
    $contents = file_get_contents($file);

    file_put_contents(
        $file,
        preg_replace('/<!--delete-->.*<!--\/delete-->/s', '', $contents) ?: $contents
    );
}

function normalizePath(string $path): string
{
    return str_replace('/', DIRECTORY_SEPARATOR, $path);
}

function getFilesWithPlaceholders(): array
{
    $directory = new RecursiveDirectoryIterator(__DIR__, RecursiveDirectoryIterator::SKIP_DOTS);
    $iterator = new RecursiveIteratorIterator($directory);

    $skipDirs = ['.git', 'vendor', 'node_modules'];
    $scriptBasename = basename(__FILE__);
    $placeholders = [':author_name', ':package', 'VendorName', 'PackageNamespace', 'skeleton', 'Skeleton', 'migration_table_name', 'author@domain.com', ':variable'];

    $files = [];

    foreach ($iterator as $file) {
        if (! $file->isFile()) {
            continue;
        }

        $path = $file->getPathname();
        $relativePath = str_replace(__DIR__.DIRECTORY_SEPARATOR, '', $path);

        // Skip excluded directories
        foreach ($skipDirs as $skipDir) {
            if (str_starts_with($relativePath, $skipDir.DIRECTORY_SEPARATOR)) {
                continue 2;
            }
        }

        // Skip this script
        if ($file->getBasename() === $scriptBasename) {
            continue;
        }

        // Check if file contains any placeholders
        $contents = file_get_contents($path);
        foreach ($placeholders as $placeholder) {
            if (stripos($contents, $placeholder) !== false) {
                $files[] = $path;
                break;
            }
        }
    }

    return $files;
}

writeln('');

$logoLines = [
    '  ███████ ██████   █████  ████████ ████ ████████',
    '  ██      ██   ██ ██   ██    ██     ██  ██',
    '  ███████ ██████  ███████    ██     ██  ██████',
    '       ██ ██      ██   ██    ██     ██  ██',
    '  ███████ ██      ██   ██    ██    ████ ████████',
];

$gradientColors = [
    '38;2;100;200;225',
    '38;2;62;170;200',
    '38;2;35;140;175',
    '38;2;25;117;147',
    '38;2;15;90;115',
];

foreach ($logoLines as $i => $line) {
    writeln(supportsAnsi() ? "\033[{$gradientColors[$i]}m{$line}\033[0m" : $line);
}

writeln('');

if (supportsAnsi()) {
    writeln("  \033[48;2;25;117;147m\033[97m ✦ Laravel Package Skeleton :: spatie.be ✦ \033[0m");
} else {
    writeln('  ✦ Laravel Package Skeleton :: spatie.be ✦');
}

writeln('');
writeln('  Thanks for using the Spatie Laravel package skeleton!');
writeln('  Let\'s get your new package configured.');
writeln('');

writeln(bold('  Author'));
writeln(dim('  Used for composer.json credits and the README.'));
writeln('');

$gitName = run('git config user.name');
$authorName = ask('Full name (e.g. John Smith)', $gitName);

$authorEmail = preg_replace('/[^a-z0-9.-]+/', '', preg_replace('/\s+/', '.', strtolower(trim($authorName)))).'@oddfellows.co.uk';

$vendorName = 'Oddfellows';
$vendorNamespace = 'Oddfellows';

writeln('');
writeln(bold('  Package'));
writeln('');

$currentDirectory = getcwd();
$folderName = basename($currentDirectory);

$packageName = ask('Package name', $folderName);
$packageSlug = slugify($packageName);

if (! str_starts_with($packageSlug, 'oddfellows-')) {
    $packageSlug = 'oddfellows-'.$packageSlug;
}

$packageSlugWithoutPrefix = remove_prefix('oddfellows-', $packageSlug);

$className = title_case($packageSlugWithoutPrefix);
$className = ask('Class name', $className);
$variableName = lcfirst($className);
$packageNamespace = title_case($packageSlug);
$description = ask('Package description', "This is my package {$packageSlug}");

writeln('');
writeln(bold('  Summary'));
writeln('');
writeln("  Author      {$authorName} ({$authorEmail})");
writeln("  Vendor      {$vendorName}");
writeln("  Package     {$packageSlug}");
writeln("  Description {$description}");
writeln("  Namespace   {$vendorNamespace}\\{$packageNamespace}");
writeln("  Class       {$className}");
writeln('');

$files = getFilesWithPlaceholders();

foreach ($files as $file) {
    replace_in_file($file, [
        ':author_name' => $authorName,
        'author@domain.com' => $authorEmail,
        ':vendor_name' => $vendorName,
        'VendorName' => $vendorNamespace,
        'PackageNamespace' => $packageNamespace,
        ':package_name' => $packageName,
        ':package_slug' => $packageSlug,
        'Skeleton' => $className,
        'skeleton' => $packageSlug,
        'migration_table_name' => title_snake($packageSlug),
        ':variable' => $variableName,
        ':package_description' => $description,
    ]);

    match (true) {
        str_contains($file, normalizePath('src/Skeleton.php')) => rename($file, normalizePath('./src/'.$className.'.php')),
        str_contains($file, normalizePath('src/SkeletonServiceProvider.php')) => rename($file, normalizePath('./src/'.$className.'ServiceProvider.php')),
        str_contains($file, normalizePath('src/Facades/Skeleton.php')) => rename($file, normalizePath('./src/Facades/'.$className.'.php')),
        str_contains($file, normalizePath('src/Commands/SkeletonCommand.php')) => rename($file, normalizePath('./src/Commands/'.$className.'Command.php')),
        str_contains($file, normalizePath('database/migrations/create_skeleton_table.php.stub')) => rename($file, normalizePath('./database/migrations/create_'.title_snake($packageSlugWithoutPrefix).'_table.php.stub')),
        str_contains($file, normalizePath('config/skeleton.php')) => rename($file, normalizePath('./config/'.$packageSlugWithoutPrefix.'.php')),
        str_contains($file, 'README.md') => remove_readme_paragraphs($file),
        default => null,
    };
}

writeln(green('  ✓ Updated '.count($files).' files'));

writeln('');
unlink(__FILE__);

writeln('');
writeln(green(bold('  ✨ You\'re all set! Happy building!')));
writeln(dim('  Need help creating a package? Check out https://laravelpackage.training'));
writeln('');
