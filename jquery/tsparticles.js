// document.addEventListener('DOMContentLoaded', function() {
//    particleground(document.getElementById('particles'),{
//             dotcolor: "#000000",
//             linecolor: "#000000"
//    });
//    // var intro = document.getElementById('intro');
//    // intro.style.marginTop = -intro.offsetHeight / 2 + 'px';
// }, false);

tsparticles.load({
   particles: {
      number: {
         value : 80,
         density :{
            enable : true,
            area : 800
         }
      },
      color : {
         value : ["#000000"]
      },
      shape :{
         type : "circle"
      },
      opacity : {
         value : 1
      },
      size : {
         value : {min :1, max:8}
      },
      links : {
         enable: true,
         distance : 150,
         color : "#808080",
         opacity : 0.5,
         width : 1
      },
      move : {
         enable : true,
         speed : 5,
         direction : "none",
         random : false,
         straight : false,
         outModes : "out"

      }
   },
   interactivity :{
      events :{
         onHover : {
            enable : true,
            mode : grab
         },
         onClick :{
            enable : true,
            mode : "push"
         }
      },
      modes :{
         grab : {
            distance : 140,
            links :{
               opacity : 1
            }
         },
         push : {
            quantity : 4
         }
      }
   }
});