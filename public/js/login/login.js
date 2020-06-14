//validacion de formulario
$(document).ready(function () 
{
    $.validator.setDefaults(
    {
        submitHandler: function () 
        {
            var correo = document.getElementById('inputCorreo').value;
            var contrasenia = document.getElementById('inputContrasenia').value;

            verificarLogin(correo, contrasenia);
        }
    });
    $('#formLogin').validate(
    {
        rules: 
        {
            correo: 
            {
                required: true,
            },
            contrasenia: 
            {
                required: true,
            }
        },
        messages: 
        {
            correo: 
            {
                required: "Ingrese su correo",
            },
            contrasenia: 
            {
                required: "Ingrese su contrasenia",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) 
        {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) 
        {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) 
        {
            $(element).removeClass('is-invalid');
        }
    });
});

function verificarLogin(correo, contrasenia)
{
    var token=document.getElementsByName("_token")[0].value;

    $.ajax(
    {
        async: true,
        crossDomain: true,

        type:'post',
        url: urlBase+"/login",
        data: {
            '_token': token,
            'correo': correo,
            'contrasenia': contrasenia
        },
        success:function(data)
        {
            if(data)
            {
                if(data == "-1")
                {
                    toastr.error('Contraseña incorrecta!');
                }
                else
                {
                    toastr.success('Sensión inciada, espere!');
                    setTimeout(function(){ window.location.replace(urlBase+"/factura");; }, 2000);
                }
            }
            else
            {
                toastr.error('Correo incorrecto!')
            }
        },
        error: function(data)
        {
            console.log(data);
            alert("error");
        }
    });
}