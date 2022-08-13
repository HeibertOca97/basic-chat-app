require('./bootstrap');

const boxChat = document.querySelector('#box-msg');

if (boxChat) {
    if (boxChat.childElementCount > 0) {
        scrollDown();
    }
}

function scrollDown() {
    const y = (boxChat.childElementCount * boxChat.children[0].clientHeight);
    boxChat.scrollBy(0, y);
}

const btn_listregister = $("#btn-list-register"),
    btn_listcontact = $("#btn-list-contact");
let boxgroup = $('.group-list-user');

function styleBoxListUser(el) {
    for (let i = 0; i < boxgroup.length; i++) {
        if (el.attr('data-name') == boxgroup.eq(i).attr('data-name')) {
            el.show();
        } else {
            boxgroup.eq(i).hide();
        }
    }
}

$(document).ready(() => {
    for (let i = 1; i < boxgroup.length; i++) {
        boxgroup.eq(i).hide();
    }

    btn_listregister.click(() => {
        styleBoxListUser(boxgroup.eq(0));
    });
    btn_listcontact.click(() => {
        styleBoxListUser(boxgroup.eq(1));
    });


});