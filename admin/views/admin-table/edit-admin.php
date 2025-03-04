<html lang="en">
<head>
    <title>Edit Admin</title>
    <link rel="icon" type="image/png" href="assets/logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-[#F9EFDA] to-blue-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-[80%] lg:w-[30%]">
        <h2 class="text-3xl font-bold text-center mb-6">EDIT ADMIN</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input class="w-full px-3 py-2 border border-black rounded" type="text" id="image_Old" name="image_Old" hidden value="<?= $admin_Data['gambar']?>">
            <input class="w-full px-3 py-2 border border-black rounded" type="number" id="id_Admin" name="id_Admin" hidden value="<?= $admin_Data['id']?>">
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="username">USERNAME</label>
                <input class="w-full px-3 py-2 border border-black rounded" type="text" id="username" name="username" required value="<?= $admin_Data['username']?>">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="email">EMAIL</label>
                <input class="w-full px-3 py-2 border border-black rounded" type="email" id="email" name="email" required value="<?= $admin_Data['email']?>">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="gambar">GAMBAR</label>
                <input name="gambar" type="file" id="gambar" class="w-full px-3 py-2 border border-black rounded"></input>
            </div>
            <div class="text-center">
                <button class="bg-[#E7B548] text-white font-bold py-2 px-4 rounded-md w-full mb-2" type="submit">EDIT</button>
            </div>
            <div class="text-center">
                <button class="bg-[#CB2828] text-white font-bold py-2 px-4 rounded-md w-full" type="submit">BACK</button>
            </div>
        </form>
    </div>
</body>
</html>