/* Dynamic styles - generated from settings */

/* All existing styles from styles.css would go here, but for brevity we'll only include navbar logo part */

/* Small brand logo for fixed navbar */
.navbar.fixed-navbar::before {
    content: '';
    position: absolute;
    width: 40px;
    height: 40px;
    padding-left: 100px !important;
    background-image: url('{{ asset($logoPath) }}?v={{ time() }}');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    {{-- right: 15px; --}}
    top: 50%;
    transform: translateY(-50%);
    opacity: 1;
    transition: opacity 0.3s ease;
    display: none;
}

@media (min-width: 992px) {
    .navbar.fixed-navbar::before {
        display: block;
    }
}

/* Additional dynamic styling when settings exist */
@if(isset($settings))
/* Company text coloring if set */
.company-title {
    color: {{ $settings->primary_color ?? '#8BB729' }};
}

/* Add any other dynamic settings-based styling here */
@endif

/* Additional dynamic rules could go here */ 