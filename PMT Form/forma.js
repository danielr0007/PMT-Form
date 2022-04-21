// ELEMENTS 
const submitButtom = document.querySelector('#submit-butoni');
const formContainer = document.querySelector('.modal-container');
const overlay = document.querySelector('.overlay');
const casilleroNumberInput = document.querySelector('#casillero-number');
const nombreInput = document.querySelector('#nombre');
const apellidoInput = document.querySelector('#apellido');
const segundoApellidoInput = document.querySelector('#segundo-apellido');
const emailInput = document.querySelector('#email');
const errorMessage = document.querySelector('#error-message');
const nombreLetter = document.querySelector('.nombre-letter');
const numberDeCasilleroLetter = document.querySelectorAll('.numero-casillero-letter');
const tabs = document.querySelectorAll('.tab');
const tabContent = document.querySelectorAll('.content');

// HIDES FORM AND OVERLAY TO REVEAL THANKYOU PAGE BELOW
/*submitButtom.addEventListener('click', function(){
    console.log('working')
    formContainer.classList.add('hide');
    overlay.classList.add('hide');
})*/

// CODE THAT CREATES A CASILLERO NUMBER BASED ON INFORMATION PROVIDED BY USER
function createCasilleroNumber(){
    if (nombreInput.value != '' && apellidoInput.value != ''){
        const apellidoFirstThreeLetters = apellidoInput.value.toUpperCase().slice(0,3);
        const nombreFirstLetter = nombreInput.value.toUpperCase().slice(0,1);
        const currentMonth = (new Date().getMonth() + 1).toString();
        const currentYear = new Date().getFullYear().toString().slice(2);
        const randomThreeNumbers = Math.floor(Math.random() * (89 - 10) + 10);
        casilleroNumberInput.value = nombreFirstLetter + apellidoFirstThreeLetters + randomThreeNumbers + currentMonth + currentYear;
    }
}

// when user presses a key while name and apellido values are not empty, then the create casillero function is called
window.addEventListener('keydown', createCasilleroNumber);


// TAB FUNCTIONALITY//////////////////////

// function that adds hide to all tabs except the first one
function addHideToAllTabsExceptOne (){
    tabContent.forEach(function(content){
        content.classList.add('hide1');
    })

    tabContent[0].classList.remove('hide1');
    tabs[0].classList.add('active-tab');
}

addHideToAllTabsExceptOne();

// function that removes active-tab from all tabs, makes font color white, and hides all tab content
function RemoveAllTabClasses(){
    tabs.forEach(function(tab){
        tab.classList.remove('active-tab');
        tab.children[0].style.color = 'white';
    })

    tabContent.forEach(function(content){
        content.classList.add('hide1');
    })
}

// function that removes hide class from tab content and makes selected tab font color yellow
function removeHide(num){
    tabContent[num].classList.remove('hide1')
    tabs[num].children[0].style.color = 'yellow';
}

tabs.forEach(function(tab){
    tab.addEventListener('click',function(e){
        RemoveAllTabClasses();
        const clicked = e.target.closest('.tab');
        // console.log(clicked.dataset.tabNumber)
        switch (clicked.dataset.tabNumber) {
            case '1':
                removeHide(0)
                clicked.classList.add('active-tab')
                break;
            case '2':
                removeHide(1)
                clicked.classList.add('active-tab')
                break;
            case '3':
                removeHide(2)
                clicked.classList.add('active-tab')
                break;
            case '4':
                removeHide(3)
                clicked.classList.add('active-tab')
                break;
            case '5':
                removeHide(4)
                clicked.classList.add('active-tab')
                break;
        }
    })
})





//OMAR************************************************************************
// !!!!   LAST UPDATED 04/06/22 09:19 PM


const form = document.getElementById('form-element');


//SENDS FORM DATA TO PHP FILE

form.addEventListener("submit", function (e){
    e.preventDefault();//prevents form from submitting onclick

    function validationSubmit(){
        if(!/^[a-zA-Z-ñÑáÁéÉíÍóÓúÚ]*$/g.test(nombreInput.value) || nombreInput.value === '' || nombreInput.value === null){
            errorMessage.innerText = 'Introduzca su nombre para continuar'
            // console.log('work name')
            return
        }
        if(!/^[a-zA-Z-ñÑáÁéÉíÍóÓúÚ]*$/g.test(apellidoInput.value) || apellidoInput.value === '' || apellidoInput.value === null){
            errorMessage.innerText = 'Introduzca su apellido para continuar'
            // console.log('work lastname')
            return
        }
        if(!/^[a-zA-Z-ñÑáÁéÉíÍóÓúÚ]*$/g.test(segundoApellidoInput.value) || segundoApellidoInput.value === '' || segundoApellidoInput.value === null){
            errorMessage.innerText = 'Introduzca su segundo apellido para continuar'
            // console.log('work lastname')
            return
        }
        
        
        
        let data = new FormData(form);

        //sends to php file
        fetch('post.php',{
            method:'POST',
            body: data
        })
            .then(res => res.text())
            .then(data =>{
                // console.log(data);
                // console.log("fetch wroked");
                    if(data === "false"){
                        alert("Este correo ya existe, contáctanos para recibir la información de nuevo");

                    }else{
                        // console.log('working')
                        
                        // hide top layer and form
                        formContainer.classList.add('hide1');
                        overlay.classList.add('hide1');
                    }
                        // add form information to letter
                        numberDeCasilleroLetter.forEach(function(span){
                            span.innerText = casilleroNumberInput.value;
                        });
                        nombreLetter.innerText = nombreInput.value;


            })
        }
            
    validationSubmit()
            
} )
//OMAR*********************
//***********************************************************************