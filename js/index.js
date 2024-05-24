const slider = document.querySelector(".slider input");
const img = document.querySelector(".images .img-2");
const dragLine = document.querySelector(".slider .drag-line");
slider.oninput = ()=>{
	let sliderVal = slider.value;
	dragLine.style.left = sliderVal + "%";
	img.style.width = sliderVal + "%";
}

$(document).ready(function(){

    // Function to initialize Owl Carousel
    function initializeOwlCarousel(carouselID, prevButtonClass, nextButtonClass) {
        var owlCarousel = $(carouselID).owlCarousel({
            items: 3, // Display three items at a time by default
            loop: true, // Enable loop
            margin: 10, // Adjust margin as needed
            nav: false, // Show or hide navigation buttons
            dots: false,
            responsive:{
                0:{
                    items: 1 // Display 1 item on smaller screens (320px or lower)
                },
                576:{
                    items: 1 // Display 1 items on screens with width 576px or higher
                },
                768:{
                    items: 1.5 // Display 1.5 items on screens with width 768px or higher
                },
                992:{
                    items: 2 // Display 2 items on screens with width 992px or higher
                },
                1200:{
                    items:2.5 // Display 2 items on screens with width 1200px or higher
                },
                1400:{
                    items:3 // Display 3 items on screens with width 1400px or higher
                }
            }
        });

        // Bind navigation buttons
        $(prevButtonClass).click(function () {
            owlCarousel.trigger('prev.owl.carousel');
        });

        $(nextButtonClass).click(function () {
            owlCarousel.trigger('next.owl.carousel');
        });
    }

    // Initialize Owl Carousel for each carousel
    initializeOwlCarousel("#owl3", '.owl-prev3', '.owl-next3');
    initializeOwlCarousel("#owl3a", '.owl-prev3a', '.owl-next3a');
});