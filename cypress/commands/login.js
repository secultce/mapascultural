function login () {
  cy.visit("/autenticacao/");
  cy.get("a[href=\"http://localhost/autenticacao/fakeLogin/?fake_authentication_user_id=1\"]").contains("Fazer login com este usuário").click();
}

module.exports = { login };
