$(document).ready(function () {
    var validator = $("#frmreg").bootstrapValidator({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                message: "Usuario requerido",
                validators: {
                    notEmpty: {
                        message: "Por favor ingrese el usuario"
                    },
                    stringLength: {
                        min: 5,
                        max: 15,
                        message: "Ingrese entre 5 y 35 caracteres"
                    }
                }
            }, email: {
                message: "E-mail requerido",
                validators: {
                    notEmpty: {
                        message: "Por favor ingrese el correo"
                    },
                    stringLength: {
                        min: 6,
                        max: 25,
                        message: "Ingrese entre 6 y 25 caracteres"
                    },
                    emailAddress: {
                        message: "Correo incorrecto"
                    }
                }
            },
            password: {
                message: "Password requerido",
                validators: {
                    notEmpty: {
                        message: "Por favor ingrese el password"
                    },
                    stringLength: {
                        min: 5,
                        max: 15,
                        message: "Ingrese minimo 5 caracteres"
                    }
                }
            },
            confirmarPassword: {
                message: "Confirmar Password requerido",
                validators: {
                    notEmpty: {
                        message: "Por favor vuelva a ingresar el password"
                    },
                    stringLength: {
                        min: 5,
                        max: 15,
                        message: "Ingrese minimo 5 caracteres"
                    },
                    identical: {
                        field: "password",
                        message: "Las passwords no son identicas"
                    }
                }
            }
        }
    }
    );
}
);