export class Video {
    init() {
        this.Video();
        this.Vimeo();
        this.Youtube();
    }
    Video() {
        $(document).ready(function () {
            // Play specific video and pause all others
            $(document).on('click', '.play-video-modal', function () {
                var $clickedVideo = $(this).closest('.video-container').find('.myVideo');

                // Pause all videos
                $('.myVideo').each(function () {
                    this.pause();
                    $(this).closest('.video-container').find('.play-video-modal').removeClass('d-none');
                    $(this).closest('.video-container').find('.play-video-preview').removeClass('d-none');
                });

                // Play clicked video
                if ($clickedVideo.length) {
                    $clickedVideo.get(0).play();
                }
                $(this).addClass('d-none');
                $(this).closest('.video-container').find('.play-video-preview').addClass('d-none');
            });

            // Close video modal and pause the video
            $(document).on('click', '.close-video-modal', function () {
                var $video = $(this).closest('.video-container').find('.myVideo');
                if ($video.length) {
                    $video.get(0).pause();
                }
                $(this).closest('.video-container').find('.play-video-modal').removeClass('d-none');
                $(this).closest('.video-container').find('.play-video-preview').removeClass('d-none');
            });

            // Play banner video
            $("#play-banner-video").click(function () {
                var $bannerVideo = $("#banner-video");

                // Pause all other videos
                $('.myVideo').each(function () {
                    this.pause();
                    $(this).closest('.video-container').find('.play-video-modal').removeClass('d-none');
                    $(this).closest('.video-container').find('.play-video-preview').removeClass('d-none');
                });

                $bannerVideo.get(0).play();
                $(this).addClass('d-none');
                $(".video-img-play, .image-section-img, .banner-img").addClass('video-img-pause');
                $(".video-preview").addClass('d-none');
            });

            // Pause banner video
            $("#pause-banner-video").click(function () {
                var $bannerVideo = $("#banner-video");
                $bannerVideo.get(0).pause();
                $("#play-banner-video").removeClass('d-none');
                $(".video-img-play, .image-section-img, .banner-img").removeClass('video-img-pause');
                $(".video-preview").removeClass('d-none');
            });

            // Handle play/pause for iframe banner video
            $("#play-banner-iframe").click(function () {
                $(this).toggleClass('d-none');
            });
        });
    }

    Vimeo() {
        document.querySelectorAll('.vimeo-video-iframe').forEach(container => {
            const playButton = container.querySelector('.play-vimeo-btn');
            const pauseButton = container.querySelector('.pause-vimeo-btn');
            const vimeoFrame = container.querySelector('.vimeo-frame');
            const coverImages = container.querySelector('.cover-images');
            const videoId = container.getAttribute('data-video-id');
            let iframe = null;

            // Play button event listener
            playButton.addEventListener('click', () => {
                // Pause all other Vimeo videos
                document.querySelectorAll('.vimeo-video-iframe').forEach(otherContainer => {
                    if (otherContainer !== container && otherContainer.querySelector('iframe')) {
                        const otherIframe = otherContainer.querySelector('iframe');
                        otherIframe.parentNode.removeChild(otherIframe);
                        otherContainer.querySelector('.play-vimeo-btn').classList.remove('d-none');
                        otherContainer.querySelector('.pause-vimeo-btn').classList.add('d-none');
                        otherContainer.querySelector('.cover-images').classList.remove('d-none');
                    }
                });

                if (!iframe) {
                    iframe = document.createElement('iframe');
                    iframe.src = `https://player.vimeo.com/video/${videoId}?autoplay=1&controls=0`;
                    iframe.frameBorder = 0;
                    iframe.allow = 'autoplay;';
                    iframe.allowFullscreen = true;
                    vimeoFrame.appendChild(iframe);
                    playButton.classList.add('d-none');
                    coverImages.classList.add('d-none');
                    pauseButton.classList.remove('d-none');
                }
            });

            // Pause button event listener
            pauseButton.addEventListener('click', () => {
                if (iframe) {
                    iframe.parentNode.removeChild(iframe);
                    iframe = null;
                    playButton.classList.remove('d-none');
                    pauseButton.classList.add('d-none');
                    coverImages.classList.remove('d-none');
                }
            });

            // Auto-pause when the mouse leaves the container
            container.addEventListener('mouseleave', () => {
                if (iframe) {
                    iframe.parentNode.removeChild(iframe);
                    iframe = null;
                    playButton.classList.remove('d-none');
                    pauseButton.classList.add('d-none');
                    coverImages.classList.remove('d-none');
                }
            });
        });
    }

    Youtube() {
        let currentPlayer = null;
        let currentPlayingModule = null;

        function initializeYouTubeAPIAndPlayers() {
            if (typeof YT === 'undefined' || typeof YT.Player === 'undefined') {
                var tag = document.createElement('script');
                tag.src = "https://www.youtube.com/iframe_api";
                document.body.appendChild(tag);

                window.onYouTubeIframeAPIReady = function () {
                    initializeVideoModules();
                };
            } else {
                initializeVideoModules();
            }
        }

        function initializeVideoModules() {
            document.querySelectorAll('.video').forEach(videoModule => {
                // Ensure that the module is initialized only once
                if (!videoModule.classList.contains('initialized')) {
                    initializeVideoModule(videoModule);
                    videoModule.classList.add('initialized');
                }
            });
        }

        function initializeVideoModule(videoModule) {
            const pauseButton = document.getElementById('modal-youtube-pause');
            const placeholder = videoModule.querySelector('.video-placeholder');

            const player = new YT.Player(placeholder, {
                videoId: videoModule.dataset.videoId,
                playerVars: {
                    'controls': 0,
                    'rel': 0,
                    'modestbranding': 1,
                    'iv_load_policy': 3
                },
                events: {
                    onStateChange: function (event) {
                        if (event.data === YT.PlayerState.ENDED) {
                            videoModule.classList.remove('playing');
                            player.destroy();
                            placeholder.innerHTML = ''; // Clear placeholder content
                            initializeVideoModule(videoModule); // Re-initialize video module
                        } else if (event.data === YT.PlayerState.PLAYING) {
                            if (currentPlayer && currentPlayer !== player) {
                                currentPlayer.pauseVideo();
                                if (currentPlayingModule) {
                                    currentPlayingModule.classList.remove('playing');
                                }
                            }
                            currentPlayer = player;
                            currentPlayingModule = videoModule;
                            videoModule.classList.add('playing');
                        }
                    }
                }
            });

            const playButton = videoModule.querySelector('.play-iframe-btn');
            if (playButton) {
                playButton.addEventListener('click', function () {
                    player.playVideo();
                    playButton.classList.add('d-none');
                });
            }

            videoModule.addEventListener('mouseleave', function () {
                playButton.classList.remove('d-none');
                if (player.getPlayerState() === YT.PlayerState.PLAYING) {
                    player.pauseVideo();
                    videoModule.classList.remove('playing');
                    if (currentPlayer === player) {
                        currentPlayer = null;
                        currentPlayingModule = null;
                    }
                }
            });

            if (pauseButton) {
                pauseButton.addEventListener('click', function () {
                    player.pauseVideo();
                    videoModule.classList.remove('playing');
                    if (currentPlayer === player) {
                        currentPlayer = null;
                        currentPlayingModule = null;
                    }
                });
            }
        }

        initializeYouTubeAPIAndPlayers();
    }
}