$(function() {
    $("form[name='contact']").validate({
        rules: {
            firstName: {
                required: true,
                pattern: "^[\\w'\\-,.][^0-9_!¡?÷?¿/\\\\+=@#$%ˆ&*(){}|~<>;:[\\]]{1,}$"
            },
            lastName: {
                required: true,
                pattern: "^[\\w'\\-,.][^0-9_!¡?÷?¿/\\\\+=@#$%ˆ&*(){}|~<>;:[\\]]{1,}$"
            },
            email: {
                required: true,
                email: true
            },
            subject: {
                required: true,
                minlength: 5,
                maxlength: 100
            },
            query: {
                required: true,
                minlength: 15,
                maxlength: 1000
            },
            phone: {
                required: false,
                pattern: "(([+][(]?[0-9]{1,3}[)]?)|([(]?[0-9]{4}[)]?))\\s*[)]?[-\\s\\.]?[(]?[0-9]{1,3}[)]?([-\\s\\.]?[0-9]{3})([-\\s\\.]?[0-9]{3,4})"
            }
        },
        messages: {
            firstName: {
                required: "Please enter your first name",
                pattern: "Please enter a valid first name"
            },
            lastName: {
                required: "Please enter your last name",
                pattern: "Please enter a valid last name"
            },
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address"
            },
            subject: {
                required: "Please enter a subject",
                minlength: "The subject should be at least 5 characters long",
                maxlength: "The subject should not be longer than 100 characters"
            },
            query: {
                required: "Please enter your question",
                minlength: "Your question should be at least 15 characters long",
                maxlength: "Your question should not be longer than 1000 characters"
            },
            phone: {
                pattern: "Please enter a valid phone number"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    })
});
