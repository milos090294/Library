'use strict';

let openCloseBtn = document.querySelector('#img-click');
let arrows = document.querySelector('.arrows');
let sidebar = document.querySelector('.sidenav');
let checker = true;

openCloseBtn.addEventListener('click', removeSidebar);

function removeSidebar()
{   
    if(checker){
        sidebar.style.width = '0px';
        arrows.style.left = '10px';
    }
    else{
        sidebar.style.width = '200px';
        arrows.style.left = '205px';
    }
    checker = !checker;
   
}


