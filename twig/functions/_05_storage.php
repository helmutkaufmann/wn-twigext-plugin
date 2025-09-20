<?php

// Initialize or extend the existing $functions array with additional functions
$functions += [

    //
    // Retrieving Files
    //

    /**
     * Retrieves the contents of a specified file from the designated storage disk.
     *
     * @param string $file The path to the file relative to the disk's root.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return string The contents of the file.
     *
     * @example
     * // Retrieve contents of 'documents/report.pdf' from the 'public' disk
     * $content = $functions['storageGet']('documents/report.pdf', 'public');
     */
    'storageGet' => function ($file, $disk = "local") {
        return Storage::disk($disk)->get($file);
    },

    //
    // File Meta Information
    //

    /**
     * Checks if a specified file exists on the designated storage disk.
     *
     * @param string $file The path to the file relative to the disk's root.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return bool True if the file exists, false otherwise.
     *
     * @example
     * // Check if 'images/photo.jpg' exists on the 'public' disk
     * $exists = $functions['storageExists']('images/photo.jpg', 'public');
     */
    'storageExists' => function ($file, $disk = "local") {
        return Storage::disk($disk)->exists($file);
    },

    /**
     * Retrieves the size of a specified file from the designated storage disk.
     *
     * @param string $file The path to the file relative to the disk's root.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return int The size of the file in bytes.
     *
     * @example
     * // Get the size of 'videos/movie.mp4' on the 'local' disk
     * $size = $functions['storageSize']('videos/movie.mp4');
     */
    'storageSize' => function ($file, $disk = "local") {
        return Storage::disk($disk)->size($file);
    },

    /**
     * Retrieves the last modified timestamp of a specified file from the designated storage disk.
     *
     * @param string $file The path to the file relative to the disk's root.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return int The Unix timestamp representing the last modification time.
     *
     * @example
     * // Get the last modified time of 'logs/app.log' on the 'local' disk
     * $lastModified = $functions['storageLastModified']('logs/app.log');
     */
    'storageLastModified' => function ($file, $disk = "local") {
        return Storage::disk($disk)->lastModified($file);
    },

    //
    // Storing Files
    //

    /**
     * Stores content into a specified file on the designated storage disk.
     *
     * @param string $file The path to the file relative to the disk's root.
     * @param string $content The content to be written to the file.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return string An empty string. (Consider returning a status or the file path for better usability)
     *
     * @example
     * // Store "Hello World" in 'notes/greeting.txt' on the 'local' disk
     * $result = $functions['storagePut']('notes/greeting.txt', 'Hello World');
     */
    'storagePut' => function ($file, $content, $disk = "local") {
        Storage::disk($disk)->put($file, $content);
        return "";
    },

    /**
     * Copies a file from one location to another on the designated storage disk.
     *
     * @param string $from The source file path relative to the disk's root.
     * @param string $to The destination file path relative to the disk's root.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return string An empty string. (Consider returning a status or confirmation message)
     *
     * @example
     * // Copy 'docs/old_report.pdf' to 'docs/new_report.pdf' on the 'local' disk
     * $result = $functions['storageCopy']('docs/old_report.pdf', 'docs/new_report.pdf');
     */
    'storageCopy' => function ($from, $to, $disk = "local") {
        Storage::disk($disk)->copy($from, $to);
        return "";
    },

    /**
     * Moves a file from one location to another on the designated storage disk.
     *
     * @param string $from The source file path relative to the disk's root.
     * @param string $to The destination file path relative to the disk's root.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return string An empty string. (Consider returning a status or confirmation message)
     *
     * @example
     * // Move 'temp/data.tmp' to 'data/data.tmp' on the 'local' disk
     * $result = $functions['storageMove']('temp/data.tmp', 'data/data.tmp');
     */
    'storageMove' => function ($from, $to, $disk = "local") {
        Storage::disk($disk)->move($from, $to);
        return "";
    },

    //
    // Prepending / Appending to Files
    //

    /**
     * Prepends content to the beginning of a specified file on the designated storage disk.
     *
     * @param string $file The path to the file relative to the disk's root.
     * @param string $content The content to prepend to the file.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return string An empty string. (Consider returning a status or confirmation message)
     *
     * @example
     * // Prepend "Start of File\n" to 'logs/app.log' on the 'local' disk
     * $result = $functions['storagePrepend']('logs/app.log', "Start of File\n");
     */
    'storagePrepend' => function ($file, $content, $disk = "local") {
        Storage::disk($disk)->prepend($file, $content);
        return "";
    },

    /**
     * Appends content to the end of a specified file on the designated storage disk.
     *
     * **Note:** There seems to be a typo in the original function where `prepend` is used instead of `append`.
     * Ensure to replace `prepend` with `append` to correctly append content.
     *
     * @param string $file The path to the file relative to the disk's root.
     * @param string $content The content to append to the file.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return string An empty string. (Consider returning a status or confirmation message)
     *
     * @example
     * // Append "\nEnd of File" to 'logs/app.log' on the 'local' disk
     * $result = $functions['storageAppend']('logs/app.log', "\nEnd of File");
     */
    'storageAppend' => function ($file, $content, $disk = "local") {
        // Corrected the method from prepend to append
        Storage::disk($disk)->append($file, $content);
        return "";
    },

    //
    // Deleting Files
    //

    /**
     * Deletes one or more specified files from the designated storage disk.
     *
     * @param string|array $files The path(s) to the file(s) relative to the disk's root.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return string An empty string. (Consider returning a status or confirmation message)
     *
     * @example
     * // Delete 'docs/old_report.pdf' from the 'local' disk
     * $result = $functions['storageDelete']('docs/old_report.pdf');
     *
     * // Delete multiple files
     * $result = $functions['storageDelete'](['docs/old_report.pdf', 'docs/legacy.docx']);
     */
    'storageDelete' => function ($files, $disk = "local") {
        Storage::disk($disk)->delete($files);
        return "";
    },

    //
    // Directories
    //

    /**
     * Retrieves an array of all files within a specified directory on the designated storage disk.
     *
     * @param string $dir The directory path relative to the disk's root.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return array An array of file paths.
     *
     * @example
     * // Get all files in 'images/products' on the 'public' disk
     * $files = $functions['storageFiles']('images/products', 'public');
     */
    'storageFiles' => function ($dir, $disk = "local") {
        return Storage::disk($disk)->files($dir);
    },

    /**
     * Retrieves an array of all files within a specified directory and its subdirectories on the designated storage disk.
     *
     * @param string $dir The directory path relative to the disk's root.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return array An array of file paths, including those in subdirectories.
     *
     * @example
     * // Get all files in 'documents' and its subdirectories on the 'local' disk
     * $allFiles = $functions['storageAllFiles']('documents');
     */
    'storageAllFiles' => function ($dir, $disk = "local") {
        return Storage::disk($disk)->allFiles($dir);
    },

    /**
     * Retrieves an array of all directories within a specified directory on the designated storage disk.
     *
     * @param string $dir The parent directory path relative to the disk's root.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return array An array of directory paths.
     *
     * @example
     * // Get all directories within 'images' on the 'public' disk
     * $directories = $functions['storageDirectories']('images', 'public');
     */
    'storageDirectories' => function ($dir, $disk = "local") {
        return Storage::disk($disk)->directories($dir);
    },

    /**
     * Retrieves an array of all directories within a specified directory and its subdirectories on the designated storage disk.
     *
     * @param string $dir The parent directory path relative to the disk's root.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return array An array of directory paths, including those in subdirectories.
     *
     * @example
     * // Get all directories within 'projects' and its subdirectories on the 'local' disk
     * $allDirectories = $functions['storageAllDirectories']('projects');
     */
    'storageAllDirectories' => function ($dir, $disk = "local") {
        return Storage::disk($disk)->allDirectories($dir);
    },

    /**
     * Deletes an entire directory and its contents from the designated storage disk.
     *
     * @param string $dir The directory path relative to the disk's root.
     * @param string $disk Optional. The storage disk to use (default is 'local').
     *
     * @return string An empty string. (Consider returning a status or confirmation message)
     *
     * @example
     * // Delete the 'temp/uploads' directory on the 'local' disk
     * $result = $functions['storageDeleteDirectory']('temp/uploads');
     */
    'storageDeleteDirectory' => function ($dir, $disk = "local") {
        Storage::disk($disk)->deleteDirectory($dir);
        return "";
    },

];

?>