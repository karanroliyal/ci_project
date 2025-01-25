$(document).ready(function () {

    console.log("Comman js is loaded");

    // Loading table on load
    getTable()

})

let baseUrls = $("#baseUrl").val();

// Logout logic is here

function logout() {


    console.log("hello clcik")

    $.ajax({
        url: baseUrls + "logincontroller/logout",
        type: "POST",
        success: function (data) {
            if (data == "success") {
                window.location.href = baseUrls + "indexcontroller";
            }
        }
    })

}

// Changing active state of tabs from this single logic

$(document).on('click', '.master-links a', function () {

    let tabId = $(this).attr("id");

    localStorage.setItem('tabName', "#" + tabId);


});

if (localStorage.getItem('tabName')) {
    let storedTab = localStorage.getItem('tabName');
    $(".master-links a").removeClass("activeTab");
    $(`${storedTab}`).addClass("activeTab");
} else {
    $("#dashoardTab").addClass("activeTab");
}



// Form validation with Insert in databse start's here 

// class which validate fields

class FormValidation {

    constructor(value, errorText, regExp, id) {

        this.value = value;
        this.errorText = errorText;
        this.regExp = regExp;
        this.id = id;

    }

    validation() {

        if (this.regExp.test(this.value)) {
            $(this.id).next(".error").text("");
        }
        else if (this.value == "") {
            $(this.id).next(".error").text("");
        }
        else {
            $(this.id).next(".error").text(this.errorText);
        }

    }

}

// fields for validation

const fileds_for_validation = [

    {
        id: "#nameId",
        errorText: "Characters are allowed and 2 min character",
        regExp: /^[a-zA-Z ]{3,50}$/,
    },
    {
        id: "#emailId",
        errorText: "Invalid email",
        regExp: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,30}$/,
    },
    {
        id: "#passwordId",
        errorText: "1 Uppercase , 1 special character , min length 8 is required and max length is 15",
        regExp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,15}$/,
    },
    {
        id: "#phoneId",
        errorText: "Invaid phone number",
        regExp: /^[0-9]{10}$/,
    },
    {
        id: "#imageId",
        errorText: "Invalid format",
        regExp: /(\.jpg|\.jpeg|\.png|\.gif)$/i,
    },
    {
        id: "",
        name_: "languages",
    },
    {
        id: "",
        name_: "gender",
    },


];

// here data goes and create object for class

fileds_for_validation.map(ele => {

    if (!ele.id == "") {

        $(ele.id).on('input', function () {

            let value = $(ele.id).val().trim();

            let validateObj = new FormValidation(value, ele.errorText, ele.regExp, ele.id);

            validateObj.validation();

        })

    }
    else {

        $(`input[name=${ele.name_}]`).on('input', function () {
            if ($(`input[name=${ele.name_}]:checked`).length > 0) {
                $(".check-error").text("");
            }
            else {
                $(".check-error").text("field is required");
                console.log("bad");
            }
        });

    }


})

// filed required
$("#tableData input").on('input', function () {
    if ($(this).is("input[name=id]")) {
        return; // This will skip the current loop for id
    }
    if ($(this).val() == "") {
        $(this).parent('.mb-3').find(".error").text('Field is required');
        checkForm = 0;
    }
    if ($(this).is(":checkbox, :radio")) {
        // Check if any checkbox or radio button in the group is checked
        let name = $(this).attr('name');  // Get the name of the checkbox/radio group
        if (name && $("input[name='" + name + "']:checked").length === 0) {
            // If none in the group is checked
            $(this).closest('.form-check').parent().find('small').text('Field is required');
            checkForm = 0;
        }
        else {
            $(this).closest('.form-check').parent().find('small').text('');
        }
    }
})



// Adding form data into datable 

function sendData() {

    let checkForm = 1;


    $("#tableData input").each(function () {
        if ($(this).is("input[name=id]")) {
            return; // This will skip the current loop for id
        }
        if ($(this).val() == "") {
            $(this).parent('.mb-3').find(".error").text('Field is required');
            checkForm = 0;
        }
        if ($(this).is(":checkbox, :radio")) {
            let name = $(this).attr('name');
            if (name && $("input[name='" + name + "']:checked").length === 0) {
                $(this).closest('.form-check').parent().find('small').text('Field is required');
                checkForm = 0;
            }
        }
        if (!$(".error").text() == "") {
            checkForm = 0;
        }
    })


    if (checkForm == 1) {

        let formData = new FormData(tableData);


        $.ajax({

            url: baseUrls + "insertcontroller/insert",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                $(".error").text("");

                if (data.errorKeys) {

                    for (let i = 0; i < data.errorKeys.length; i++) {

                        $(`input[name="${data.errorKeys[i]}"]`).next().text(data.errorValues[i]);

                        if (data.errorKeys[i].indexOf("[]") >= 0) {
                            $(`input[name="${data.errorKeys[i]}"]`).closest('.form-check').parent().find('small').text(data.errorValues[i]);
                            console.log("comming []")
                        }

                        if (data.errorValues[i] == "") {
                            $(`input[name="${data.errorKeys[i]}"]`).next().text("Field is required")
                        }

                    }

                }
                if (data.imageError) {
                    let imageUploadError = data.imageError;
                    imageUploadError = imageUploadError.replace("<p>", "")
                    imageUploadError = imageUploadError.replace("</p>", "")

                    $(".my-backend-error").removeClass('d-none');
                    $(".my-backend-error").text(imageUploadError);

                    setTimeout(function () {
                        $(".my-backend-error").addClass('d-none');
                        $(".my-backend-error").text("");
                    }, 4000)


                }
                if (data.status == "success") {
                    $(".my-backend-success").removeClass('d-none');
                    $(".my-backend-success").text("Form Submitted successfully");
                    $("#tableData").trigger("reset");

                    let change = $("#nav-home-tab");
                    let tab = new bootstrap.Tab(change);
                    tab.show();

                    setTimeout(function () {
                        $(".my-backend-success").addClass('d-none');
                        $(".my-backend-success").text("");
                    }, 4000)
                    $("#tableData").trigger('reset');
                }

            }

        })

    } else {
        console.log("validate things");
    }


}

// Form validation with Insert in databse end's here 

// resetting form on click of homeTab

$("#nav-home-tab").on('click', function () {

    $("#tableData").trigger("reset");
    $("#tableData .error").text("");

})


// Table creation Dynamically and Live Search AJAX call start **********************************************************

function getTable() {
    let formData = new FormData(liveSearchForm);
    
    $.ajax({
        
        url: baseUrls + "tablecontroller",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            data = JSON.parse(data);
            console.log(data);
            $(".myDynamicTable").html(data.table)
            $(".dynamicPagination").html(data.pagination)
        }
        
    })
}

// Table creation Dynamically and Live Search AJAX call end **********************************************************


// Live data Search start *******************************************************

$("#liveSearchForm input").on('input', function () {

    $("#pageId").val(1);
    getTable();

})

// Live data Search end **********************************************************

// Pagination  start *****************************

$(document).on("click", ".my-pagination .li", function () {
    let page = $(this).attr("id");
    
    $("#pageId").val(page);
    
    console.log(page);
    getTable();
});

// next button pagination
$(document).on('click', '.next', function () {
    
    let page = $(this).parents('.my-pagination').find('.active').attr('id');
    let totalPage = $(".my-pagination").attr("id");
    console.log(totalPage)
    page = Number(page) + 1;
    if (page <= totalPage) {
        $("#pageId").val(page);
        getTable();
    }
    
})

// previous button pagination
$(document).on('click', '.prev', function () {
    
    let page = $(this).parents('.my-pagination').find('.active').attr('id');
    page = Number(page) - 1;
    console.log(page)
    if(page>0){
        $("#pageId").val(page);
        getTable();
    }
    
})

// Pagination  end *******************************


// selecting limit of records start **************************************

$("#rowId").on('input' , function () {

    let value = $(this).val();
    $("#limit").val(value);
    getTable();

})

// selecting limit of records end ******************************************

// sorting on table start **********

let sortOrder = "DESC";
$(document).on('click' , ".sortingClass" ,  function() {

    if(sortOrder == "DESC"){
        sortOrder = "ASC";
    }else{
        sortOrder = "DESC";
    }
    $sortOn = $(this).data("sort");

    $("#sortOrder").val(sortOrder);
    $("#sortOn").val($sortOn);

    getTable();

})

// sorting on table end **********





