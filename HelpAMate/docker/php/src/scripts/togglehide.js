function toggleHide(element) {
    console.log(element)
    let classes = element.className;
    let y = document.querySelector(".blurbg");
    let x;

    if (classes.includes("login")) {
        x = document.querySelector(".loginpopup");
    } else if (classes.includes("pledgeBox") || classes.includes("removepledge")) {
        x = document.querySelector(".removepledge");
        document.getElementById("pledgeName").innerText = element.getAttribute("data-pledge-name");
        document.getElementById("pledgeAmount").innerText = "$" + element.getAttribute("data-pledge-amount");
        document.getElementById("pledgeId").value = element.getAttribute("data-pledge-id");
    } else if (classes.includes("delete")) {
        x = document.querySelector(".deletepopup");
    } else if (classes.includes("pledge")) {
        x = document.querySelector(".pledge");
    }
    
    if (x.style.display == '') {
        x.style.display = "none";
        y.style.display = "none";
    }
    
    if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "block";
    } else if (x.style.display === "block") {
        x.style.display = "none";
        y.style.display = "none";
    }
}