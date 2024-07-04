import { footer } from "../../commands/footer";

describe("Homepage", () => {
  beforeEach(() => {
    cy.visit("/");
    cy.log("Página inicial carregada");
  });

  it("testa a funcão footer", () => {
    footer();
  });
});
