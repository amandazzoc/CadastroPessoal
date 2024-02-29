const input = document.querySelector('cpf')

input.addEventListener('keypress', () => {
    //mostra o tamanho
    let inputlenght = input.ariaValueMax.length

    if (inputlenght === 3 || inputlenght === 7){
        input.value += '.'
    }else if (inputlenght === 11){
        input.value += '-'
    }
})