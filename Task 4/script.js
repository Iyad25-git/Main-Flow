let display = document.getElementById('display');
let currentInput = '';

function appendValue(value) {
    currentInput += value;
    display.value = currentInput;
}

function appendOperator(operator) {
    if (currentInput === '' || isOperator(currentInput.slice(-1))) {
        return; // Prevents consecutive operators
    }
    currentInput += operator;
    display.value = currentInput;
}

function appendDecimal() {
    let parts = currentInput.split(/[\+\-\*\/]/);
    let lastPart = parts[parts.length - 1];

    if (!lastPart.includes('.')) {
        currentInput += '.';
        display.value = currentInput;
    }
}

function clearDisplay() {
    currentInput = '';
    display.value = '';
}

function backspace() {
    currentInput = currentInput.slice(0, -1); // Removes last character
    display.value = currentInput;
}

function calculateResult() {
    try {
        if (isOperator(currentInput.slice(-1))) {
            return; // Prevents calculation if last input is an operator
        }
        let result = eval(currentInput);
        display.value = result;
        currentInput = result.toString();
    } catch (error) {
        display.value = "Error";
        currentInput = '';
    }
}

function isOperator(value) {
    return ['+', '-', '*', '/'].includes(value);
}
