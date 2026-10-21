const formatAudioTime = (seconds) => {
    if (!Number.isFinite(seconds)) {
        return '0:00';
    }

    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = Math.floor(seconds % 60).toString().padStart(2, '0');
    return `${minutes}:${remainingSeconds}`;
};

const updateArchiveClock = () => {
    const now = new Date();
    const pad = (value) => value.toString().padStart(2, '0');
    const date = document.querySelector('[data-current-date]');
    const time = document.querySelector('[data-current-time]');

    if (date) {
        date.textContent = `${pad(now.getDate())}.${pad(now.getMonth() + 1)}.${now.getFullYear()}`;
    }
    if (time) {
        time.textContent = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
    }
};

updateArchiveClock();
if (document.querySelector('[data-current-time]')) {
    window.setInterval(updateArchiveClock, 1000);
}

const shufflePhotos = (collage) => {
    const photos = [...collage.querySelectorAll('[data-photo-item]')];
    const layouts = ['portrait', 'landscape', 'wide', 'tall', 'square'];

    for (let index = photos.length - 1; index > 0; index -= 1) {
        const randomIndex = Math.floor(Math.random() * (index + 1));
        [photos[index], photos[randomIndex]] = [photos[randomIndex], photos[index]];
    }

    const visiblePhotos = window.innerWidth <= 768 ? photos.slice(0, 10) : photos;
    const hiddenPhotos = photos.slice(visiblePhotos.length);

    visiblePhotos.forEach((photo, index) => {
        photo.className = `photo ${layouts[Math.floor(Math.random() * layouts.length)]}`;
        photo.style.order = index;
        photo.hidden = false;
        collage.appendChild(photo);
    });
    hiddenPhotos.forEach((photo) => {
        photo.hidden = true;
        collage.appendChild(photo);
    });
};

document.querySelectorAll('[data-photo-collage]').forEach((collage) => {
    shufflePhotos(collage);

    const shuffleButton = collage.closest('[data-module="photography_project"]')
        ?.querySelector('[data-photo-shuffle]');
    shuffleButton?.addEventListener('click', () => shufflePhotos(collage));
});

document.querySelectorAll('[data-module="hero_front"]').forEach((hero) => {
    const photos = [...hero.querySelectorAll('[data-hero-photo]')];
    if (!photos.length) {
        return;
    }

    let lastPhoto;
    let lastShownAt = 0;
    const showRandomPhoto = () => {
        const now = performance.now();
        if (now - lastShownAt < 250) {
            return;
        }

        const photo = photos[Math.floor(Math.random() * photos.length)];
        if (photo === lastPhoto && photos.length > 1) {
            return;
        }

        photos.forEach((item) => {
            item.classList.remove('is-visible');
        });
        photo.style.left = `${15 + Math.random() * 70}%`;
        photo.style.top = `${15 + Math.random() * 70}%`;
        photo.classList.add('is-visible');
        lastPhoto = photo;
        lastShownAt = now;
    };

    hero.addEventListener('pointermove', () => {
        if (window.matchMedia('(max-width: 768px)').matches) {
            return;
        }
        showRandomPhoto();
    });

    window.addEventListener('scroll', () => {
        if (window.matchMedia('(max-width: 768px)').matches) {
            showRandomPhoto();
        }
    }, { passive: true });
});

window.addEventListener('resize', () => {
    document.querySelectorAll('[data-photo-collage]').forEach(shufflePhotos);
});

document.querySelectorAll('[data-audio-player]').forEach((player) => {
    const audio = player.querySelector('audio');
    const toggle = player.querySelector('[data-audio-toggle]');
    const seek = player.querySelector('[data-audio-seek]');
    const current = player.querySelector('[data-audio-current]');
    const duration = player.querySelector('[data-audio-duration]');
    const fill = player.querySelector('[data-audio-fill]');
    const thumb = player.querySelector('[data-audio-thumb]');

    if (!audio || !toggle || !seek || !current || !duration || !fill || !thumb) {
        return;
    }

    const updateProgress = () => {
        const progress = audio.duration ? audio.currentTime / audio.duration : 0;
        const percentage = `${Math.min(100, Math.max(0, progress * 100))}%`;
        current.textContent = formatAudioTime(audio.currentTime);
        fill.style.width = percentage;
        thumb.style.left = percentage;
    };

    const updateDuration = () => {
        if (Number.isFinite(audio.duration)) {
            duration.textContent = formatAudioTime(audio.duration);
        }
    };

    const updateToggle = () => {
        const isPlaying = !audio.paused;
        toggle.textContent = isPlaying ? '[PAUSE]' : '[ABSPIELEN]';
        toggle.setAttribute('aria-label', isPlaying ? 'Audio pausieren' : 'Audio abspielen');
    };

    toggle.addEventListener('click', () => {
        if (audio.paused) {
            audio.play().catch((error) => {
                console.error('Audio konnte nicht abgespielt werden.', error);
                updateToggle();
            });
        } else {
            audio.pause();
        }
    });

    seek.addEventListener('click', (event) => {
        if (!audio.duration) {
            return;
        }

        const bounds = seek.getBoundingClientRect();
        const position = Math.min(1, Math.max(0, (event.clientX - bounds.left) / bounds.width));
        audio.currentTime = position * audio.duration;
    });

    audio.addEventListener('loadedmetadata', () => {
        updateDuration();
        updateProgress();
    });
    audio.addEventListener('durationchange', updateDuration);
    audio.addEventListener('timeupdate', updateProgress);
    audio.addEventListener('play', updateToggle);
    audio.addEventListener('pause', updateToggle);
    audio.addEventListener('ended', () => {
        updateToggle();
        updateProgress();
    });
});
