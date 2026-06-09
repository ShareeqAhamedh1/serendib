<?php
// Simple PHP File Manager with Directory Reading, Server Info, Upload, Create File/Folder, and Edit File
// WARNING: This is a basic demo. In production, add authentication, security checks, and restrict access to prevent unauthorized file operations or data exposure.

// Get current directory from GET parameter, default to current script directory
$currentDir = isset($_GET['dir']) ? realpath($_GET['dir']) : __DIR__;

// Ensure the directory is within the allowed path (basic security)
$baseDir = __DIR__; // Restrict to script's directory
if (!$currentDir || !is_dir($currentDir)) {
    $currentDir = __DIR__;
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploadFile'])) {
    $uploadFile = $_FILES['uploadFile'];
    if ($uploadFile['error'] === UPLOAD_ERR_OK && $uploadFile['size'] > 0) {
        $targetPath = $currentDir . DIRECTORY_SEPARATOR . basename($uploadFile['name']);
        if (is_writable($currentDir) && move_uploaded_file($uploadFile['tmp_name'], $targetPath)) {
            $message = "File uploaded successfully.";
        } else {
            $message = "Failed to upload file. Check permissions.";
        }
    } else {
        $message = "Upload error: File is empty or invalid.";
    }
    // Redirect to avoid resubmission
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

// Handle create file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createFile'])) {
    $fileName = trim($_POST['fileName']);
    $fileContent = $_POST['fileContent'] ?? '';
    if (!empty($fileName) && !preg_match('/[\/\\\\:*?"<>|]/', $fileName)) {
        $filePath = $currentDir . DIRECTORY_SEPARATOR . $fileName;
        if (!file_exists($filePath) && is_writable($currentDir)) {
            if (file_put_contents($filePath, $fileContent) !== false) {
                $message = "File created successfully.";
            } else {
                $message = "Failed to create file.";
            }
        } else {
            $message = "File already exists or directory not writable.";
        }
    } else {
        $message = "Invalid file name.";
    }
    // Redirect to avoid resubmission
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

// Handle create folder
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createFolder'])) {
    $folderName = trim($_POST['folderName']);
    if (!empty($folderName) && !preg_match('/[\/\\\\:*?"<>|]/', $folderName)) {
        $folderPath = $currentDir . DIRECTORY_SEPARATOR . $folderName;
        if (!file_exists($folderPath) && is_writable($currentDir)) {
            if (mkdir($folderPath)) {
                $message = "Folder created successfully.";
            } else {
                $message = "Failed to create folder.";
            }
        } else {
            $message = "Folder already exists or directory not writable.";
        }
    } else {
        $message = "Invalid folder name.";
    }
    // Redirect to avoid resubmission
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

// Handle edit file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editFile'])) {
    $filePath = $_POST['filePath'];
    $fileContent = $_POST['fileContent'] ?? '';
    if (file_exists($filePath) && is_writable($filePath)) {
        if (file_put_contents($filePath, $fileContent) !== false) {
            $message = "File edited successfully.";
        } else {
            $message = "Failed to edit file.";
        }
    } else {
        $message = "File not found or not writable.";
    }
    // Redirect to avoid resubmission
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

// Function to list directory contents
function listDirectory($dir) {
    $items = [];
    if (is_dir($dir) && is_readable($dir)) {
        $handle = opendir($dir);
        while (($item = readdir($handle)) !== false) {
            if ($item !== '.' && $item !== '..') {
                $fullPath = $dir . DIRECTORY_SEPARATOR . $item;
                $items[] = [
                    'name' => $item,
                    'path' => $fullPath,
                    'is_dir' => is_dir($fullPath),
                    'size' => is_file($fullPath) ? filesize($fullPath) : 0,
                    'modified' => date('Y-m-d H:i:s', filemtime($fullPath))
                ];
            }
        }
        closedir($handle);
    }
    return $items;
}

// Function to display server info
function displayServerInfo() {
    $info = [
        'Server Software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
        'PHP Version' => phpversion(),
        'Server Name' => $_SERVER['SERVER_NAME'] ?? 'N/A',
        'Document Root' => $_SERVER['DOCUMENT_ROOT'] ?? 'N/A',
        'Current User' => get_current_user(),
        'OS' => PHP_OS,
        'Memory Limit' => ini_get('memory_limit'),
        'Max Upload Size' => ini_get('upload_max_filesize')
    ];
    return $info;
}

$items = listDirectory($currentDir);
$serverInfo = displayServerInfo();

// For edit modal
$editFile = null;
if (isset($_GET['edit']) && is_file($_GET['edit']) && strpos(realpath($_GET['edit']), $baseDir) === 0) {
    $editFile = $_GET['edit'];
    $editContent = file_get_contents($editFile);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP File Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Simple PHP File Manager</h1>
        
        <!-- Message Display -->
        <?php if (isset($message)): ?>
            <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <!-- Current Directory -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Current Directory: <?php echo htmlspecialchars($currentDir); ?></h2>
            <?php if (dirname($currentDir) !== $currentDir): ?>
                <a href="?dir=<?php echo urlencode(dirname($currentDir)); ?>" class="text-blue-500 hover:underline">⬆️ Go Up</a>
            <?php endif; ?>
        </div>
        
        <!-- Actions: Upload, Create File, Create Folder -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Upload File -->
            <div>
                <h3 class="text-md font-semibold mb-2">Upload File</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="file" name="uploadFile" required class="mb-2 border border-gray-300 rounded px-2 py-1">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Upload</button>
                </form>
            </div>
            
            <!-- Create File -->
            <div>
                <h3 class="text-md font-semibold mb-2">Create File</h3>
                <form method="POST">
                    <input type="text" name="fileName" placeholder="File name (e.g., test.txt)" required class="mb-2 border border-gray-300 rounded px-2 py-1 w-full">
                    <textarea name="fileContent" placeholder="File content (optional)" class="mb-2 border border-gray-300 rounded px-2 py-1 w-full h-20"></textarea>
                    <button type="submit" name="createFile" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Create File</button>
                </form>
            </div>
            
            <!-- Create Folder -->
            <div>
                <h3 class="text-md font-semibold mb-2">Create Folder</h3>
                <form method="POST">
                    <input type="text" name="folderName" placeholder="Folder name" required class="mb-2 border border-gray-300 rounded px-2 py-1 w-full">
                    <button type="submit" name="createFolder" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">Create Folder</button>
                </form>
            </div>
        </div>
        
        <!-- Directory Contents -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">Directory Contents</h2>
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Type</th>
                        <th class="border border-gray-300 px-4 py-2">Size (bytes)</th>
                        <th class="border border-gray-300 px-4 py-2">Modified</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">
                                <?php if ($item['is_dir']): ?>
                                    <a href="?dir=<?php echo urlencode($item['path']); ?>" class="text-blue-500 hover:underline">
                                        📁 <?php echo htmlspecialchars($item['name']); ?>
                                    </a>
                                <?php else: ?>
                                    📄 <?php echo htmlspecialchars($item['name']); ?>
                                <?php endif; ?>
                            </td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $item['is_dir'] ? 'Directory' : 'File'; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $item['size']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $item['modified']; ?></td>
                            <td class="border border-gray-300 px-4 py-2">
                                <?php if (!$item['is_dir']): ?>
                                    <a href="<?php echo htmlspecialchars($item['path']); ?>" target="_blank" class="text-green-500 hover:underline mr-2">View</a>
                                    <a href="?edit=<?php echo urlencode($item['path']); ?>" class="text-yellow-500 hover:underline mr-2">Edit</a>
                                    <a href="<?php echo htmlspecialchars($item['path']); ?>" download class="text-orange-500 hover:underline">Download</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Edit File Modal -->
        <?php if ($editFile): ?>
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
                    <h3 class="text-lg font-semibold mb-4">Edit File: <?php echo htmlspecialchars(basename($editFile)); ?></h3>
                    <form method="POST">
                        <input type="hidden" name="filePath" value="<?php echo htmlspecialchars($editFile); ?>">
                        <textarea name="fileContent" class="w-full h-64 border border-gray-300 rounded px-2 py-1 mb-4"><?php echo htmlspecialchars($editContent); ?></textarea>
                        <div class="flex justify-end">
                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="mr-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
                            <button type="submit" name="editFile" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Server Info -->
        <div>
            <h2 class="text-lg font-semibold mb-2">Server Information</h2>
            <table class="w-full table-auto border-collapse border border-gray-300">
                <tbody>
                    <?php foreach ($serverInfo as $key => $value): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2 font-semibold"><?php echo htmlspecialchars($key); ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($value); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>