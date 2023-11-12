let rotation = [{src: "./img/logo1.svg", name: "Vortex Vision"},{src: "./img/logo2.svg", name: "Echostream"},{src: "./img/logo3.svg", name: "Saurkraut Corporation"},{src: "./img/logo4.svg", name: "Schniwetzel"},{src: "./img/logo5.svg", name: "Questionarre"},{src: "./img/logo6.svg", name: "Nimbus Dynamics"},{src: "./img/logo7.svg", name: "Panthen Inc."}]
let index = 0;
let indexrotation = 4 // already showing

let placements = document.querySelectorAll('.moving-image');
let destroyafter
                     /* distribute time equally */
let equalspacing = 10000 / placements.length
destroyafter = setInterval(function() {
      placements[index].classList.add("animatenow")
      let img = document.createElement('img');
      img.src = rotation[index].src;
      let title = document.createElement('h3');
      title.textContent = rotation[index].name;
      placements[index].append(img)
      placements[index].append(title)

      index++;
      if(index === 4){
        clearInterval(destroyafter)
        index=0
        setInterval(function() {
          placements[index].children[0].src = rotation[indexrotation].src
          placements[index].children[1].textContent = rotation[indexrotation].name
          indexrotation++
          index++;
        if(index === placements.length){
          index = 0
        }
        if(indexrotation == rotation.length){
          indexrotation =0
        }
   },equalspacing)
      }
   }, equalspacing);
