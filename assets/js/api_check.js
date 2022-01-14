function verifică() {

                                if (document.getElementById("apikey").value !== "") {
                                    document.getElementById("info").removeAttribute("hidden");
                                    document.getElementById("info").setAttribute("hidden", "");
                                    var xhr = new XMLHttpRequest();
                                    xhr.open("POST", "https://pseudointerpreter.ro/api.php", true);
                                    xhr.setRequestHeader('Content-Type', 'application/json');
                                    xhr.send(JSON.stringify({
                                        type: "verifica",
                                        apikey: document.getElementById("apikey").value
                                    }));
                                    xhr.onload = function() {
                                        var data = JSON.parse(this.responseText);
                                        if (data.status === false) {
                                            alert(data.response);
                                        } else if (data.status === true) {
                                            document.getElementById("api_id").innerHTML = "ID: " + data.response.id;
                                            document.getElementById("api_key").innerHTML = "Cheie API: " + data.response.api_key;
                                            document.getElementById("api_domain").innerHTML = "Domeniu: " + data.response.domain;
                                            document.getElementById("api_requests").innerHTML = "Cereri efectuate: " + data.response.used_requests;
                                            document.getElementById("api_total").innerHTML = "Cereri totale: " + data.response.total_requests;
                                            document.getElementById("info").removeAttribute("hidden");
                                        }
                                    }
                                }
                            }