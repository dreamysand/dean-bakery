<html lang="en">
<head>
    <title>Forgot Password</title>
    <link rel="icon" type="image/png" href="assets/logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-[#F9EFDA] to-blue-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-[80%] lg:w-[30%]">
        <h2 class="text-3xl font-bold text-center mb-6">FORGOT PASSWORD</h2>
        <form method="POST" action="">
            <?php if (!isset($_SESSION['forgot']) || 
                $_SESSION['forgot'] == 0
            ): ?>
                <?php require 'views/forgot-password/page-1.php'; ?>
            <?php elseif (isset($_SESSION['forgot']) &&
                $_SESSION['forgot'] == 1
            ): ?>
                <?php require 'views/forgot-password/page-2.php'; ?>
            <?php endif ?>
            <div class="text-center">
                <button class="bg-[#E7B548] text-white font-bold py-2 px-4 rounded-md w-full mb-2" type="submit">NEXT</button>
            </div>
            <div class="text-center">
                <button class="bg-[#CB2828] text-white font-bold py-2 px-4 rounded-md w-full" type="submit">BACK</button>
            </div>
        </form>
    </div>
</body>
</html>