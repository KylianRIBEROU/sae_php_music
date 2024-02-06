<div>

</div>

<div class="relative ml-3">
    <div class="flex items-center">
        <h2 class="text-white mr-3">Marin</h2>

        <button type="button" class="rounded-full bg-gray" id="user-menu-button">
            <img class="h-12 w-12 rounded-full" src="https://api.dicebear.com/7.x/adventurer-neutral/svg?seed=marin" alt="profile image">
        </button>
    </div>

    <div class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded bg-gray py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" id="user-menu">
        <a href="#" class="block p-3 mx-1 text-sm text-white rounded hover:bg-gray-hover ">Profil</a>
        <a href="#" class="block p-3 mx-1 text-sm text-white rounded hover:bg-gray-hover">Deconnexion</a>
    </div>
</div>

<script>
    // Get the menu button element
    const menuButton = document.getElementById('user-menu-button');

    // Get the user menu element
    const userMenu = document.getElementById('user-menu');

    // Add event listener to the menu button
    menuButton.addEventListener('click', function() {
        // Toggle the 'hidden' class on the user menu
        userMenu.classList.toggle('hidden');
    });
</script>

