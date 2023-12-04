<?php
session_start();
include 'admin_class.php';

if(!$_SESSION['admin_id']){
    header('location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload with Suffix</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        button {
            padding: 5px 10px;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<input type="file" id="fileInput">
<button onclick="uploadFile()">Upload</button>

<div id="result">
    <table>
        <thead>
            <tr>
                <th>File Name</th>
            </tr>
        </thead>
        <tbody id="fileTableBody"></tbody>
    </table>
</div>

<script>
let fileCounter = 1;

function handleFileUpload(file) {
    const resultDiv = document.getElementById('fileTableBody');

    const originalFileName = file.name;
    let newFileName = originalFileName;

    // Check if the filename already exists in the table
    const existingFileNames = Array.from(resultDiv.querySelectorAll('td')).map(cell => cell.textContent);
    
    while (existingFileNames.includes(newFileName)) {
        // If the filename already exists, add a numerical suffix
        const dotIndex = originalFileName.lastIndexOf('.');
        newFileName = `${originalFileName.slice(0, dotIndex)}(${fileCounter++})${originalFileName.slice(dotIndex)}`;
    }

    // Display the result in the table
    const newRow = resultDiv.insertRow();
    const cell1 = newRow.insertCell(0);
    cell1.innerHTML = newFileName;
}

function uploadFile() {
    const fileInput = document.getElementById('fileInput');

    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        handleFileUpload(file);
    } else {
        alert('No file selected');
    }
}
</script>

</body>
</html>
