function setupSelectComponent() {
    let i, selectSelectedDiv, selectListDiv;

    let selectRootDiv = document.getElementsByClassName("select-main");

    for (i = 0; i < selectRootDiv.length; i++) {
        let selectElement = selectRootDiv[i].getElementsByTagName("select")[0];

        selectSelectedDiv = document.createElement("div");
        selectSelectedDiv.setAttribute("class", "select-selected");
        selectSelectedDiv.innerHTML = '' +
            '<p class="select-selected-icon">' + selectRootDiv[i].getAttribute("data-icon") + '</p>' +
            '<p class="select-selected-text ' + (selectElement.selectedIndex > 0 && selectElement.options[selectElement.selectedIndex].selected ? ' select-selectect-text-choosen' : '') + '">' + selectElement.options[selectElement.selectedIndex].innerHTML + '</p>' +
            '<p class="select-selected-arrow">􀆈</p>';

        if (selectRootDiv[i].classList.contains("select-error")) {
            selectSelectedDiv.classList.add("select-selected-error");
        }

        selectListDiv = document.createElement("div");
        selectListDiv.setAttribute("class", "select-list select-list-hide");

        for (let j = 1; j < selectElement.length; j++) {
            let c = document.createElement("div");
            c.innerHTML = selectElement.options[j].innerHTML;

            if (j === 1) {
                c.style.borderBottomLeftRadius = "0";
                c.style.borderBottomRightRadius = "0";
                c.style.borderBottom = "1px solid #E6ECF0";
            } else if (j === selectElement.length - 1) {
                c.style.borderTopLeftRadius = "0";
                c.style.borderTopRightRadius = "0";
            } else {
                c.style.borderRadius = "0";
                c.style.borderBottom = "1px solid #E6ECF0";
            }

            c.addEventListener("click", function(e) {
                let selectListDiv;
                let selectElement = this.parentNode.parentNode.getElementsByTagName("select")[0];
                let previousSibling = this.parentNode.previousSibling;

                for (let i = 0; i < selectElement.length; i++) {
                    if (selectElement.options[i].innerHTML === this.innerHTML) {
                        selectElement.selectedIndex = i;
                        previousSibling.getElementsByClassName("select-selected-text")[0].innerHTML = this.innerHTML;
                        previousSibling.getElementsByClassName("select-selected-text")[0].className = "select-selected-text select-selectect-text-choosen";

                        selectListDiv = this.parentNode.getElementsByClassName("select-list-selected");

                        for (let j = 0; j < selectListDiv.length; j++) {
                            selectListDiv[j].removeAttribute("class");
                        }

                        this.setAttribute("class", "select-list-selected");

                        break;
                    }
                }

                c.addEventListener("hover", function (e) {
                   console.log("test");
                });

                this.parentNode.previousSibling.click();
            });

            selectListDiv.appendChild(c);
        }

        selectRootDiv[i].appendChild(selectSelectedDiv);
        selectRootDiv[i].appendChild(selectListDiv);

        selectSelectedDiv.addEventListener("click", function(e) {
            e.stopPropagation();

            hideList(this);

            this.nextSibling.classList.toggle("select-list-hide");
            this.classList.toggle("select-arrow-active");

            if (this.getElementsByClassName("select-selected-arrow")[0].innerHTML === "􀆈") {
                this.getElementsByClassName("select-selected-arrow")[0].innerHTML = "􀆇"
            } else {
                this.getElementsByClassName("select-selected-arrow")[0].innerHTML = "􀆈"
            }
        });
    }

    function hideList(elmnt) {
        let x, y, i, arrNo = [];

        x = document.getElementsByClassName("select-list");
        y = document.getElementsByClassName("select-selected");

        for (i = 0; i < y.length; i++) {
            if (elmnt === y[i]) {
                arrNo.push(i)
            } else {
                y[i].getElementsByClassName("select-selected-arrow")[0].innerHTML = "􀆈";
            }
        }

        for (i = 0; i < x.length; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-list-hide");
            }
        }
    }

    document.addEventListener("click", hideList);
}

setupSelectComponent();