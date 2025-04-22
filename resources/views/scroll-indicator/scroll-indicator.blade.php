<div class="absolute left-4 top-1/4 transform -translate-y-1/2 scroll-indicator flex flex-row items-center gap-2">
    <i class="fas fa-chevron-right text-white/70 text-3xl arrow-small"></i>
    <i class="fas fa-chevron-right text-white/60 text-2xl arrow-medium"></i>
    <i class="fas fa-chevron-right text-white/50 text-xl arrow-large"></i>
</div>
<style>
  .scroll-indicator {
    opacity: 1;
    transition: opacity 0.5s ease;
    z-index: 10;
    position: relative;
}

.scroll-indicator.hide {
    opacity: 0;
}

.arrow-large, .arrow-medium, .arrow-small {
    opacity: 0;
    transform: translateX(-10px);
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.arrow-large {
    font-size: 1.875rem; /* text-3xl equivalent */
    animation: fadeInArrow 2s infinite; /* First arrow starts immediately */
}

.arrow-medium {
    font-size: 1.5rem; /* text-2xl equivalent */
    animation: fadeInArrow 2s infinite 0.2s; /* Delayed by 0.2s */
}

.arrow-small {
    font-size: 1.25rem; /* text-xl equivalent */
    animation: fadeInArrow 2s infinite 0.4s; /* Delayed by 0.4s */
}

@keyframes fadeInArrow {
    0% { opacity: 0; transform: translateX(-10px); }
    50% { opacity: 1; transform: translateX(0); }
    100% { opacity: 0; transform: translateX(10px); }
}

.scroll-progress-33 .arrow-large,
.scroll-progress-66 .arrow-medium,
.scroll-progress-100 .arrow-small {
    opacity: 0;
    transform: translateX(10px);
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const scrollIndicators = document.querySelectorAll('.scroll-indicator');
    const maxScroll = document.documentElement.scrollHeight - window.innerHeight;

    window.addEventListener('scroll', () => {
        const scrollProgress = (window.scrollY / maxScroll) * 100;

        scrollIndicators.forEach(scrollIndicator => {
            if (scrollProgress > 0) scrollIndicator.classList.add('scroll-progress-33');
            if (scrollProgress > 33) scrollIndicator.classList.add('scroll-progress-66');
            if (scrollProgress > 66) scrollIndicator.classList.add('scroll-progress-100');
            if (scrollProgress > 90) scrollIndicator.classList.add('hide');
            if (scrollProgress === 0) {
                scrollIndicator.classList.remove(
                    'scroll-progress-33',
                    'scroll-progress-66',
                    'scroll-progress-100',
                    'hide'
                );
            }
        });
    });
});
</script>
