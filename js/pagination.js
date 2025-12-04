$(document).ready(function(){
    let paginationLeftPos = "20px";
    let paginationOpacity = 0;
    let checkPaginationClick = 0;

    $(".pagination-page-number").click(function() {
    $(".pagination-page-number").removeClass("active");
    $(this).addClass("active");
    paginationLeftPos = $(this).prop("offsetLeft") + "px";
    paginationOpacity = 1;
    checkPaginationClick = 1;

    $(".pagination-hover-overlay").css({
        left: paginationLeftPos,
        backgroundColor: "#333333",
        opacity: paginationOpacity
    });
    $(this).css({
        color: "#fff"
    });
    });

    $(".pagination-page-number").hover(
    function() {
        paginationOpacity = 1;
        $(".pagination-hover-overlay").css({
        backgroundColor: "#5fa77f",
        left: $(this).prop("offsetLeft") + "px",
        opacity: paginationOpacity
        });

        $(".pagination-page-number.active").css({
        color: "#333d45"
        });

        $(this).css({
        color: "#fff"
        });
    },
    function() {
        if (checkPaginationClick) {
        paginationOpacity = 1;
        } else {
        paginationOpacity = 0;
        }

        $(".pagination-hover-overlay").css({
        backgroundColor: "#333333",
        opacity: paginationOpacity,
        left: paginationLeftPos
        });

        $(this).css({
        color: "#333d45"
        });

        $(".pagination-page-number.active").css({
        color: "#fff"
        });
    }
    );

});