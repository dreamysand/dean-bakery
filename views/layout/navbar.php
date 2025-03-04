<nav class="bg-[#101018] text-white p-4 fixed top-0 left-0 right-0 z-[997]">
    <div class="flex justify-between items-center">
        <img src="<?php echo "http://".$_SERVER['HTTP_HOST'].DIRECTORY_SEPARATOR."dean-bakery\assets".DIRECTORY_SEPARATOR."logo.png"; ?>" class="w-[7vh] bg-[#E7B548] rounded-xl">
        <button id="sidebarToggle" class="text-white">
            <!-- Icon Burger Menu -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>
</nav>
<div id="overlay"></div>
<aside id="sidebar" class="fixed top-0 left-0 h-full bg-[#101018] text-white p-6">
    <nav>
        <?php include __DIR__.DIRECTORY_SEPARATOR."navbar-variants".DIRECTORY_SEPARATOR."admin.php"; ?>
    </nav>
</aside>

<style>
    #sidebar {
        width: 250px;
        background-color: #101018;
        position: fixed;
        top: 0;
        bottom: 0;
        left: -250px;
        transition: left 0.3s ease;
        z-index: 999;
    }

    #sidebar.active {
        left: 0;
    }
    #sidebar a.active {
        background: #7BC7A2;
        color: black;
    }

    /* Overlay */
    #overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 998;
    }

    #overlay.active {
        display: block;
    }
</style>
<script>
    document.getElementById('sidebarToggle').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mainContent = document.getElementById('mainContent');

        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        mainContent.classList.toggle('shifted');
    });

    document.getElementById('overlay').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mainContent = document.getElementById('mainContent');

        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        mainContent.classList.remove('shifted');
    });
</script>