$( document ).ready(function() {
    $("#trening").click(function(){
        let treningId = $(this).val();
        $.ajax({
            url: "/treningy/pridaj",
            type: "POST",
            dataType: 'json',
            data: {
                treningId : treningId,
            }
        })
            .done (function(data, textStatus, jqXHR) {
                console.log(data);
                alert(data.message);
            })
            .fail (function(jqXHR, textStatus, errorThrown) {
                alert("Error");//ak je chyba v kode (php )
            })
            .always (function(jqXHROrData, textStatus, jqXHROrErrorThrown) {
            });
    });

    $("#pouzivatelia").click(function(){
        $("#recordList").remove();//vymaze tabulku aby mohla prist dalsia
        $.ajax({
            url: "/admin/pouzivatelia",
            type: "POST",
            dataType: 'json',
            data: {

            }
        })
            .done (function(data, textStatus, jqXHR) {
                console.log(1);
                $containerHtml= $("#contentContainer");
                $tabulka=$(data.message);//$ je jQuery
                $containerHtml.append($tabulka);
                $(".editUser").click(function(){
                    console.log("test");
                    let button=$(this);
                    let row=button.closest("tr");
                    let dataInputs = {
                        userName: row.find(".userName").first().val(),
                        password: row.find(".password").first().val(),
                        name: row.find(".name").first().val(),
                        surname: row.find(".surname").first().val()
                    }

                    $.ajax({
                        url: "/admin/pouzivatelia/edit/"+button.val(),
                        type: "POST",
                        dataType: 'json',
                        data: {
                            inputs:dataInputs

                        }
                    })
                        .done (function(data, textStatus, jqXHR) {
                            alert(data.message);
                            $("#pouzivatelia").trigger("click");//stlaci tlacitko

                        })
                        .fail (function(jqXHR, textStatus, errorThrown) {
                            alert("Error");//ak je chyba v kode (php )
                        })
                        .always (function(jqXHROrData, textStatus, jqXHROrErrorThrown) {
                        });
                });
                $(".deleteUser").click(function(){
                    console.log("test");
                    let button=$(this);
                    let row=button.closest("tr");



                    $.ajax({
                        url: "/admin/pouzivatelia/remove/"+button.val(),
                        type: "POST",
                        dataType: 'json',
                        data: {
                        }
                    })
                        .done (function(data, textStatus, jqXHR) {
                            alert(data.message);
                            $("#pouzivatelia").trigger("click");//stlaci tlacitko

                        })
                        .fail (function(jqXHR, textStatus, errorThrown) {
                            alert("Error");//ak je chyba v kode (php )
                        })
                        .always (function(jqXHROrData, textStatus, jqXHROrErrorThrown) {
                        });
                });

            })
            .fail (function(jqXHR, textStatus, errorThrown) {
                alert("Error");//ak je chyba v kode (php )
            })
            .always (function(jqXHROrData, textStatus, jqXHROrErrorThrown) {
            })


    })
    $("#produkty").click(function(){
        $("#recordList").remove();//vymaze tabulku aby mohla prist dalsia
        $.ajax({
            url: "/admin/produkty",
            type: "POST",
            dataType: 'json',
            data: {

            }
        })
            .done (function(data, textStatus, jqXHR) {
                console.log(1);
                $containerHtml= $("#contentContainer");
                $tabulka=$(data.message);//$ je jQuery
                $containerHtml.append($tabulka);
                $(".editProduct").click(function(){
                    let button=$(this);
                    let row=button.closest("tr");
                    let dataInputs = {
                        nameproduct: row.find(".nameproduct").first().val(),
                        description: row.find(".description").first().val(),
                        price: row.find(".price").first().val(),
                        quantity: row.find(".quantity").first().val()
                    }

                    $.ajax({
                        url: "/admin/produkty/edit/"+button.val(),
                        type: "POST",
                        dataType: 'json',
                        data: {
                            inputs:dataInputs
                        }
                    })
                        .done (function(data, textStatus, jqXHR) {
                            console.log(button.val());
                            alert(data.message);

                            $("#produkty").trigger("click");//
                        })
                        .fail (function(jqXHR, textStatus, errorThrown) {
                            alert("Error");//ak je chyba v kode (php )
                        })
                        .always (function(jqXHROrData, textStatus, jqXHROrErrorThrown) {
                        });
                });

            })

            .fail (function(jqXHR, textStatus, errorThrown) {
                alert("Error");//ak je chyba v kode (php )
            })
            .always (function(jqXHROrData, textStatus, jqXHROrErrorThrown) {
            });

    })
    $("#treningy").click(function(){
        $("#recordList").remove();//vymaze tabulku aby mohla prist dalsia
        $.ajax({
            url: "/admin/treningy",
            type: "POST",
            dataType: 'json',
            data: {

            }
        })
            .done (function(data, textStatus, jqXHR) {
                console.log(1);
                $containerHtml= $("#contentContainer");
                $tabulka=$(data.message);//$ je jQuery
                $containerHtml.append($tabulka);
                $(".editTrening").click(function(){
                    let button=$(this);
                    let row=button.closest("tr");
                    let dataInputs = {
                        nametrening: row.find(".nametrening").first().val(),
                        pricetrening: row.find(".pricetrening").first().val(),
                        descriptiontrening: row.find(".descriptiontrening").first().val()

                    }

                    $.ajax({
                        url: "/admin/treningy/edit/"+button.val(),
                        type: "POST",
                        dataType: 'json',
                        data: {
                            inputs:dataInputs
                        }
                    })
                        .done (function(data, textStatus, jqXHR) {
                            console.log(button.val());
                            alert(data.message);

                            $("#treningy").trigger("click");//
                        })
                        .fail (function(jqXHR, textStatus, errorThrown) {
                            alert("Error");//ak je chyba v kode (php )
                        })
                        .always (function(jqXHROrData, textStatus, jqXHROrErrorThrown) {
                        });
                });

            })

            .fail (function(jqXHR, textStatus, errorThrown) {
                alert("Error");//ak je chyba v kode (php )
            })
            .always (function(jqXHROrData, textStatus, jqXHROrErrorThrown) {
            });

    })

});
