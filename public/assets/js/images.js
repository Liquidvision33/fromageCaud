let links = document.querySelectorAll("[data-delete]");

for (let link of links) {
    link.addEventListener("click", function (e) {
        e.preventDefault();
        if (confirm("Voulez-vous supprimer cette image ?")) {
            fetch(this.getAttribute("href"), {
                method: "DELETE",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({"_token": this.dataset.token})
            })
                .then(response => response.json())
                .then(data => {
                    // Ajoutez ce journal pour afficher la valeur du jeton CSRF envoyé
                    console.log("Sent CSRF token: " + this.dataset.token);
                    if (data.success) {
                        this.parentElement.remove();
                    } else {
                        alert(data.error);
                    }
                })
        }
    });
}