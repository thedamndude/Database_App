<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            "firstname" => $_POST['firstname'],
            "lastname"  => $_POST['lastname'],
            "email"     => $_POST['email'],
            "age"       => $_POST['age'],
            "location"  => $_POST['location']
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "users",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['firstname']; ?> successfully added.</blockquote>
<?php } ?>
<script>
function validate()
	{
		/*alert("we are validating your data");
		return false;*/
		var firstname=document.forms["create"]["firstname"].value;
		var lastname=document.forms["create"]["lastname"].value;
		var email=document.forms["create"]["email"].value;
		var age=document.forms["create"]["age"].value;
		var location=document.forms["create"]["location"].value;
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		if(firstname=="")
		{
			alert("Enter Firstname");
			document.forms["create"]["firstname"].focus();
			return false;
		}
		if(lastname=="")
		{
			alert("Enter Lastname");
			document.forms["create"]["lastname"].focus();
			return false;
		}
		if(email=="")
		{
			alert("Enter email");
			document.forms["create"]["email"].focus();
			return false;
		}
		
		var x=document.forms["create"]["email"].value
		var atposition=x.indexOf("@");
		var dotposition=x.lastIndexOf(".");
		if(atposition<1 || dotposition<atposition+2 || dotposition+2>=x.length)
		{
			alert("enter the valid email");
			document.forms["create"]["email"].focus();
			return false;
		}
		
		if(age=="")
		{
			alert("Enter age");
			document.forms["create"]["age"].focus();
			return false;
		}
		if(isNaN(age))
		{
			alert("Enter valid age");
			document.forms["create"]["age"].focus();
			return false;
		}
		if(location=="")
		{
			alert("confirm your location");
			document.forms["create"]["location"].focus();
			return false;
		}
	}
</script>

<h2>Add a user</h2>

<form method="post" name="create" onsubmit="return validate()">
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname">
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
    <label for="age">Age</label>
    <input type="text" name="age" id="age">
    <label for="location">Location</label>
    <input type="text" name="location" id="location">
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
