export const usePasswordGenerator = () => {
  const length = 10;
  const charset = {
    uppercase: "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
    lowercase: "abcdefghijklmnopqrstuvwxyz",
    numbers: "0123456789",
    symbols: ".!#$%&'*+/=?^_`{|}~-",
  };

  let password =
    charset.uppercase.charAt(Math.floor(Math.random() * charset.uppercase.length)) +
    charset.lowercase.charAt(Math.floor(Math.random() * charset.lowercase.length)) +
    charset.numbers.charAt(Math.floor(Math.random() * charset.numbers.length)) +
    charset.symbols.charAt(Math.floor(Math.random() * charset.symbols.length));

  const allChars = charset.uppercase + charset.lowercase + charset.numbers + charset.symbols;
  for (let i = password.length; i < length; i++) {
    password += allChars.charAt(Math.floor(Math.random() * allChars.length));
  }

  password = password
    .split("")
    .sort(() => 0.5 - Math.random())
    .join("");

  return password;
};
