
function executaMascara() {
    objeto.value = funcao(objeto.value)

}
function validarFuncionario() {
    let nome = document.getElementById("nome_funcionario").value;
    let telefone = document.getElementById("telefone").value;
    let email = document.getElementById("email").value;

    if (nome.length < 3) {
        alert("O nome do funcionário deve ter pelo menos 3 caracteres.");
        return false;
    }

    let regexTelefone = /^[0-9]{10,11}$/;
    if (!regexTelefone.test(telefone)) {
        alert("Digite um telefone válido (10 ou 11 dígitos).");
        return false;
    }

    let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email)) {
        alert("Digite um e-mail válido.");
        return false;
    }

    return true;




// Executar mascaras
function mascara(o, f) //Define o objeto e chama a função
{
    objeto = o
    funcao = f
    setTimeout("executaMascara()", 1)

}

function executaMascara() {
    objeto.value = funcao(objeto.value)

}

// NOME
function nome(variavel) {
    variavel = variavel.replace(/[^a-zA-ZÀ-ÿ\s]/g, ""); // Remove números e caracteres especiais
    return variavel;
}



}






