
function validarSenha(form) { 
    password = document.register_form.pass.value
    password_confirm = document.register_form.pass_confirm.value
    if (password != password_confirm){
        alert("Senhas não conferem! Informe novamente");
        document.register_form.pass.focus();  
        return false;
    }
}