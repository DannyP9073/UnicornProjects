function validateEmail(field)
{
  if (field == "")
  { 
    return " No email entered.\n"
  }
  else if (!((field.indexOf(".") > 0) && (field.indexOf("@") > 0)) || /[^a-zA-Z0-9.@_-]/.test(field))
  {
    return "The email address is invalid.\n"
  }
  return "";
}

function validatePassword(field)
{
  if (field == "")
  {
    return "No password entered.\n"
  }
  else if  (field.length < 6)
  {
    return "Password must have a minimum of 6 characters.\n"
  }
  else if (!/[a-z]/.test(field) || ! /[A-Z]/.test(field) || !/[0-9]/.test(field)) 
  {
    return  "Passwords require one of each of a-z, A-Z and 0-9.\n"
  }
  return ""
}

function validateUsername(field)
{
  if (field == "")
  {
    return "No username or email entered.\n"
  }
  return ""
}

function validateLogPassword(field)
{
  if (field == "")
  {
    return "No password entered.\n"
  }
  return ""
}