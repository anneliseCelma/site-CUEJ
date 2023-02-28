const floatingSquare = document.querySelector('#floatingSquare');
const scrollY = window.scrollY;



if (floatingSquare !== null && scrollY < 100) {
    // const e = event;
    // let posX = window.event.pageX;
    // let posY = e.clientY;

    document.addEventListener('mousemove', (event) => {

        let fsWidth = floatingSquare.clientWidth;
        let fsHeight = floatingSquare.clientHeight;
        let fsPosX = Math.sqrt(event.clientX ) * 2;
        console.log(fsPosX);
        let fsPosY = Math.sqrt(event.clientY ) * 2;
        
        if ((!isNaN(fsPosY)) && (!isNaN(fsPosX))) {
            floatingSquare.style.cssText += "transform : translate(calc(" + fsPosX + "px - 50%), " + fsPosY + "px);";
        }

        // console.log(!isNaN(fsPosX));
        // console.log(fsPosX);

    });

}