const calculatorDisplay = document.querySelector('h1');
const info = document.querySelector('h5');
const inputBtns = document.querySelectorAll('button');
const clearBtn = document.getElementById('clear-button');
const transferBn = document.getElementById('myInput');

let firstValue = 0;
let operatorValue = '';
let awaitingNextValue = false;

function sendNumberValue(number) {
    calculatorDisplay.textContent = number;
}

function updateInputs() {
    document.getElementById('deposit').value = document.querySelector('h1').textContent;
    document.getElementById('withdraw').value = document.querySelector('h1').textContent;
    document.getElementById('transfer').value = document.querySelector('h1').textContent;
}

// Add Event Listeners for numbers, operators, decimal
inputBtns.forEach((inputBtn) => {
    if (inputBtn.classList.length === 0) {
        inputBtn.addEventListener('click', () => sendNumberValue(inputBtn.value));
    }
});

// Reset all values, display
function resetAll() {
    calculatorDisplay.textContent = '0';
    transferBn.value = '';
    if (info) info.remove();
}

setInterval(myTimer, 3000);

function myTimer() {
    if (info) info.remove();
}

// Event Listener
clearBtn.addEventListener('click', resetAll);
