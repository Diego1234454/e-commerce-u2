<footer class="site-footer border-top">

<!-- Foteer -->
<div class="footer">
        <div class="container">
            <div class="copyright">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script> Developed by: <a href="" target="_blank">E-Commerce Website</a>
            </div>
        </div>
    </div>

    <!-- js for toggle menu -->
    <script>
        var MenuItems = document.getElementById("MenuItems");

        MenuItems.style.maxHeight = "100px";

        function menutoggle() {
            if (MenuItems.style.maxHeight == "0px") {
                MenuItems.style.maxHeight = "300px";
            } else {
                MenuItems.style.maxHeight = "0px";
            }
        }
    </script>
