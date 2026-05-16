let btn_menu = document.getElementById('btn-menu');
if(btn_menu){
    btn_menu.addEventListener("click", function(e){
        e.preventDefault();
        let navLateral   = document.getElementById('navLateral');
        let pageContent  = document.getElementById('pageContent');
        navLateral.classList.toggle('navLateral-change');
        if(pageContent) pageContent.classList.toggle('pageContent-change');
    });
}

let btn_subMenu = document.querySelectorAll(".btn-subMenu");
btn_subMenu.forEach(subMenu => {
    subMenu.addEventListener("click", function(e){
        e.preventDefault();
        btn_subMenu.forEach(other => {
            if(other !== this) other.classList.remove('btn-subMenu-show');
        });
        this.classList.toggle('btn-subMenu-show');
    });
});

document.addEventListener('DOMContentLoaded', () => {
    function openModal($el)  { $el.classList.add('is-active'); }
    function closeModal($el) { $el.classList.remove('is-active'); }
    function closeAllModals(){ (document.querySelectorAll('.modal') || []).forEach(($m) => closeModal($m)); }

    (document.querySelectorAll('.js-modal-trigger') || []).forEach(($trigger) => {
        const modal   = $trigger.dataset.target;
        const $target = document.getElementById(modal);
        if($target) $trigger.addEventListener('click', () => openModal($target));
    });

    (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
        const $target = $close.closest('.modal');
        if($target) $close.addEventListener('click', () => closeModal($target));
    });

    document.addEventListener('keydown', (event) => {
        if(event.code === 'Escape') closeAllModals();
    });
});
