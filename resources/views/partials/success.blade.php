<div class="offcanvas offcanvas-bottom show" style="background: var(--bg-primary);" tabindex="-1" id="offcanvasBottom"
    aria-labelledby="offcanvasBottomLabel">
    <div class="offcanvas-header pb-0">
        <h5 style="font-size:1.300rem; " class="offcanvas-title text-primary text-center w-100" id="offcanvasBottomLabel">
            Félicitaion
        </h5>
        <button type="button" class="btn-close text-primary" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <p style="font-size: 1.125rem;" class="text-center">
            {{ session('success') }}
        </p>
    </div>
</div>
