# Branches e Releases

Este documento detalha o fluxo de branches e releases para o projeto, incluindo as diferenças entre releases de *hotfix* e de *feature*.

## Branches Principais

- **main**: Branch principal onde as versões estáveis são integradas e liberadas.
- **developers/**: Branches dedicadas a *features* específicas, criadas conforme a necessidade de integração de uma nova funcionalidade.

## Fluxo de Releases

### Hotfix Releases

- *Pull Requests* (PRs) para *hotfixes* são liberados assim que:
   - Passam pela aprovação de pelo menos um revisor.
   - São validados pela equipe de QA.
   
- Após a aprovação e o QA, o *merge* do *hotfix* é feito diretamente na **main** para uma liberação rápida da correção.

### Feature Releases

- Cada *feature* é associada a uma branch específica na estrutura **developers/**, criada a partir da **main**.
   
   - **Exemplo de branch para feature**: `developers/INTEGRACAO`

- Os cards de tarefas associados à *feature* são liberados para essa branch de *feature* (`developers/INTEGRACAO`).

- Quando todas as tarefas relacionadas ao card "pai" da *feature* são concluídas e aprovadas, a branch de *feature* (`developers/INTEGRACAO`) é **mergeada na main** para lançamento.

## Para mais informações de nomenclatura de PRs e branches

- [Pull Requests](./patterns/pull-requests.md)
