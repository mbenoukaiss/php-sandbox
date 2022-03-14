<?php require_once "error_reporting.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Sandbox</title>

    <link rel="icon" type="image/png" href="/icon.png">
    <link rel="stylesheet" href="../assets/style/main.css">
</head>
<body class="line-numbers">
<header>
</header>

<main>
    <div class="code-container">
        <div id="editor" class="content">
            <span class="start-token token delimiter important">&lt;?php</span>
        </div>
        <button class="run-code">Run</button>
    </div>
    <div class="content parent-content">
        <div id="output" class="content"><i>No output</i></div>

        <div class="details">
            <b>PHP version :</b> <?php echo phpversion() ?><br>
            <b>Error reporting :</b> <?php echo join(", ", getReportedErrors()); ?><br>
            <b>Loaded extensions :</b> <?php echo strtolower(join(", ", get_loaded_extensions())); ?>
        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cash/8.1.1/cash.min.js"
        integrity="sha512-X+cPfvYTMQ4sCK62U3QG9rdhziHcvR48TwiEJmlaXOpQH/aSaarxkL+zahylcvcZLDkGujg4o/ORdjSeBsRlMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/prism.min.js"
        integrity="sha512-/Swpp6aCQ0smuZ+zpklJqMClcUlvxhpLf9aAcM7JjJrj2waCU4dikm3biOtMVAflOOeniW9qzaNXNrbOAOWFCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/components/prism-markup-templating.min.js"
        integrity="sha512-TbMpeuT8rHP3DrAX8tSkpspYIT3It0fypBn5XaSp+Hiy3n9wvPFjd3pal7YtesrphulbmxcLNB9E0sq7xDGtWg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/components/prism-markup.min.js"
        integrity="sha512-+ELqhG7rn9xgybNJa3VI05AczCW2IaKwpKdDC5lD8RMAGc6t+OEV0Cta1QyKCrsncgaRHiN80atxfVo72+M8xg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/components/prism-clike.min.js"
        integrity="sha512-/Rynaa6ehLZJO9fdk+EUsgiOdJqFSFUB4Qgy+gP4vU4U1DrmPJWypfXe1CgyaV7rRdZjGxdpLe9djxhx1ZHvqQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/components/prism-php.min.js"
        integrity="sha512-KOkS8eLK1Yv2m7GNQvoAFe+4EPXYKHWEl+V1i5fS45rFBojwaMXdZ0RAnKyOV25GSwlDlwuUvX+rLBmvtmsqfg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/components/prism-php-extras.min.js"
        integrity="sha512-unfkMuV3J0s1Jnjb6QfhKmk6oISTPnl2m3s08qLdafVgDiLBrV5vdapZ/KAFUoWyC9gqQsG7cffJKFKDXsdO2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../assets/editor.js"></script>
<script src="../assets/sandbox.js"></script>
</body>
</html>