$(function () {
    $('#registeruser-dob').datepicker({
//        endDate: new Date(),
        format: "dd/mm/yyyy",
        autoclose: true
    })
    $('#imgupdate').val(0);
    var imgcheck = $('#imgcheck').val();
    if (imgcheck == 1)
    {
        $('#browse').hide();
        $('#removeimage').show();
        $('#remove').show();
    } else {
        $('#browse').show();
        $('#removeimage').hide();
        $('#remove').hide();
    }
    $('body').on('click', '#remove', function (e) {
// $('#remove').click(function(e) {
        $('#removeimage').hide();
        $('#remove').hide();
        $('#browse').show().val('');
        $('#imgupdate').val(1);
        e.preventDefault();
    });
    $("#browse").change(function () {
        readURL(this);
    });
    $('#city-country_id').change(function () {
        var country_id = $(this).val();
        $.ajax({
            type: 'post',
            url: 'getstates?id=' + country_id,
            success: function (data) {
                $('#city-state_id').html(data);
            }
        });
    });
    $('#registeruser-country').change(function () {
        var country_id = $(this).val();
        $.ajax({
            type: 'post',
            url: 'getstates?id=' + country_id,
            success: function (data) {
                $('#registeruser-state').html(data);
            }
        });
    });
    $('#registeruser-state').change(function () {
        var country_id = $(this).val();
        $.ajax({
            type: 'post',
            url: 'getcities?id=' + country_id,
            success: function (data) {
                $('#registeruser-city').html(data);
            }
        });
    });
//   
    $('.delete_photo').click(function () {
        $(".new_photo_area img").remove();
        $('.jcrop-holder').remove();
        $('.new_photo_area').hide();
        $('.crp_btn').hide();
        $('.upload').show();
        $('.preview_pane').hide();
        $('#profile_pic').val('');
    });
    $('.delete_photo1').click(function () {
        $(".new_photo_area img").remove();
        $('.crp_btn').hide();
        $('.upload').show();
        $('.preview_pane').hide();
        $('#profile_pic').val('');
        $(this).hide();
    });
    $(".crop_photo").click(function () {

        var x = $("#x").val();
        var y = $("#y").val();
        var w = $("#w").val();
        var h = $("#h").val();
        var ext = $('#extension').val();
        $.ajax({
            type: "post",
            url: "save-image",
            data: {
                x: x,
                y: y,
                w: w,
                h: h,
                src: ext
            },
            success: function (data)
            {
                $('.preview_pane').show();
                $('.thumbnail').attr('src', '../../profile_pic/' + data);
                $('#profile_pic').val(data);
            }
        });
    });
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".new_photo_area").append("<img class='cr' src='" + e.target.result + "' alt='uploaded image' style='width:150px'/>").show();
            $('.crp_btn').show();
            $('.upload').hide();
            $('#extension').val(e.target.result);
            var image = new Image();
            image.src = e.target.result;

            image.onload = function () {
                var x1 = (this.width - 150) / 2;
                var y1 = (this.height - 150) / 2;
                var x2 = x1 + 150;
                var y2 = y1 + 150;

                $('.cr').Jcrop({
                    allowSelect: true,
                    allowMove: true,
                    allowResize: true,
                    aspectRatio: 1,
                    minSize: [170, 170],
                    setSelect: [x1, y1, x2, y2],
                    boxWidth: $('.new_photo_area').width(),
                    boxHeight: $('.new_photo_area').height(),
                    onSelect: updateCoords,
                });
            };
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function updateCoords(c)
{
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
}