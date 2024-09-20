<? php
$check = mail("zs693038@gmail.com","Testing email", "this is testing","From:arshveer757@gmail.com");

if($check)
{
    echo "email sent successfully";

}
else
{
    echo "email is not sent";
}
?>