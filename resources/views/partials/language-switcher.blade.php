<div class="dropdown ms-2">
    <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" id="languageDropdown"
        data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-globe me-1"></i> {{ strtoupper(app()->getLocale()) }}
    </button>
    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
        <li>
            <a class="dropdown-item {{ app()->getLocale() === 'es' ? 'active' : '' }}"
                href="{{ route('lang.switch', 'es') }}">
                Español
            </a>
        </li>
        <li>
            <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                href="{{ route('lang.switch', 'en') }}">
                English
            </a>
        </li>
    </ul>
</div>