<div class="grow">

        <div class="relative min-w-64 w-1/3  ">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-white dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input hx-get="/search" hx-target="#main" hx-trigger="keyup changed delay:500ms" type="text" id="search" name="search" autocomplete="off" class="bg-gray block w-full p-3 ps-10 text-sm rounded-full border border-gray-dark  hover:border-gray-light focus:ring-white focus:border-white focus:outline-none focus:ring-1 text-white placeholder:text-gray-light focus:ring-blue-500 " placeholder="Que souhaitez-vous écouter" required>
        </div>
</div>

<div class="relative ml-3">
    <div class="flex items-center">
        <h2 class="text-white mr-3"><?php echo ucfirst($_SESSION['username']); ?></h2>

        <button type="button" class="rounded-full bg-gray" id="user-menu-button">
            <img class="h-12 w-12 rounded-full" src="https://api.dicebear.com/7.x/adventurer-neutral/svg?seed=<?php echo $_SESSION['username'] ?>" alt="profile image">
        </button>
    </div>

    <div class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded bg-gray py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" id="user-menu">
        <a href="/profil" class="block p-3 mx-1 text-sm text-white rounded hover:bg-gray-dark-hover ">Profil</a>
        <a href="/logout" class="block p-3 mx-1 text-sm text-white rounded hover:bg-gray-dark-hover">Déconnexion</a>
    </div>
</div>

<script>
    //Dropdown menu

    // Get the menu button element
    const menuButton = document.getElementById('user-menu-button');

    // Get the user menu element
    const userMenu = document.getElementById('user-menu');

    // Add event listener to the menu button
    menuButton.addEventListener('click', function() {
        // Toggle the 'hidden' class on the user menu
        userMenu.classList.toggle('hidden');
    });
    // Add event listener to the document object
    document.addEventListener('click', function(event) {
        // Check if the clicked element is outside the user menu
        if (!userMenu.contains(event.target) && !menuButton.contains(event.target)) {
            // Hide the user menu
            userMenu.classList.add('hidden');
        }
    });
</script>

