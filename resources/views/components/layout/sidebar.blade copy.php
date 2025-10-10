<div class="w-64 bg-[#d0d0d0] fixed top-16 bottom-0 left-0 flex flex-col justify-between shadow-md">

    <!-- Menú de navegación -->
    <nav class="flex-1 overflow-auto p-2">
        <div class="space-y-2">
            <!-- Centros Section -->
            <div class="bg-base-200 rounded-lg">
                <button class="w-full text-left p-3 flex justify-between items-center hover:bg-base-300 rounded-lg transition-colors" onclick="toggleSection('centres')">
                    <span class="text-lg font-medium text-[#555555]">Centres</span>
                    <svg class="w-5 h-5 transform transition-transform" id="centres-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="centres-content" class="hidden px-3 pb-3">
                    <ul class="text-[#555555] space-y-1">
                        <li>
                            <a href="{{ route('centers_list') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none rounded">
                                Llistar Centres
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('centers_desactivated_list') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none rounded">
                                Llistar Centres <small>(Desactivats)</small>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('center_form') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none rounded">
                                Afegir Centre
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Professionals Section -->
            <div class="bg-base-200 rounded-lg">
                <button class="w-full text-left p-3 flex justify-between items-center hover:bg-base-300 rounded-lg transition-colors" onclick="toggleSection('professionals')">
                    <span class="text-lg font-medium text-[#555555]">Professionals</span>
                    <svg class="w-5 h-5 transform transition-transform" id="professionals-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="professionals-content" class="hidden px-3 pb-3">
                    <ul class="text-[#555555] space-y-1">
                        <li>
                            <a href="{{ route('professionals_list') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none rounded">
                                Llistar Professionals
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('professionals_desactivated_list') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none rounded">
                                Llistar Professionals <small>(Desactivats)</small>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('professional_form') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none rounded">
                                Afegir Professional
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Projectes/Comissions Section -->
            <div class="bg-base-200 rounded-lg">
                <button class="w-full text-left p-3 flex justify-between items-center hover:bg-base-300 rounded-lg transition-colors" onclick="toggleSection('projectes')">
                    <span class="text-lg font-medium text-[#555555]">Projectes/Comissions</span>
                    <svg class="w-5 h-5 transform transition-transform" id="projectes-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="projectes-content" class="hidden px-3 pb-3">
                    <ul class="text-[#555555] space-y-1">
                        <li>
                            <a href="{{ route('projectcommissions_list') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none rounded">
                                Llistar Projectes/Comissions
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('projectcommissions_desactivated_list') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none rounded">
                                Llistar Projectes/Comissions <small>(Desactivats)</small>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('projectcommission_form') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none rounded">
                                Afegir Projecte/Comissió
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Logo de la empresa abajo -->
    <div class="p-4">
        <img src="{{ asset('images/paradis-logo.svg') }}" alt="Paradis Logo" class="w-full">
    </div>

</div>

<script>
// Sidebar functionality with localStorage persistence
function toggleSection(sectionId) {
    const content = document.getElementById(sectionId + '-content');
    const icon = document.getElementById(sectionId + '-icon');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
        localStorage.setItem('sidebar-' + sectionId, 'open');
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
        localStorage.setItem('sidebar-' + sectionId, 'closed');
    }
}

// Restore sidebar state on page load
document.addEventListener('DOMContentLoaded', function() {
    const sections = ['centres', 'professionals', 'projectes'];
    
    sections.forEach(sectionId => {
        const savedState = localStorage.getItem('sidebar-' + sectionId);
        const content = document.getElementById(sectionId + '-content');
        const icon = document.getElementById(sectionId + '-icon');
        
        if (savedState === 'open') {
            content.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
        } else {
            content.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
        }
    });
});
</script>
