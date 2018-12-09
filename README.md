# ZfMetal\SecurityJwt
Modulo de Zend Framework 3 que permite la autenticacion por JWT

## Dependencias
El modulo tiene una dependecia con **ZfMetal\Security** y **Doctrine\ORM**

## Autenticacion
El modulo cuenta con una ruta/action que permite la autenticacion por jwt

`ruta: /auth`

`method: post`

`params: 'username' & 'password'`

#### Autenticación Exitosa

**StatusCode**: 200

`{
success: true,
message: 'Authentication successful',
token: 'The_Token'
}`

#### Autenticacion Fallida (faltan de parametros)
**StatusCode**: 422

`{
success: false,
message: "Missing Params. username and password required.",
}`

#### Autenticacion Fallida (Credenciales Invalidas)
**StatusCode**: 401

`{
success: false,
message: 'Invalid Credentials',
}`


## Identity
Es posible obtener el usuario almacenado en el token mediante el servicio **JwtDoctrineIdentity**. Ademas se encuentra disponible un plugin controller **getJwtIdentity()**.

En caso positivo se el usuario identificado en el token (\ZfMetal\Security\Entity\User)

Es posible consultar la identidad invocando la siguiente ruta/action

`ruta: /my-identity`

`method: get`

`header: Authorization Bearer xxTOKENxx`

## Protected Controller
Es posible proteger los controladores de invocaciones sin token, tokens invalidos o token expirados extendiendo de ZfMetal\SecurityJwt\Controller\AbstractProtectedController.

Tambien es posible disponer de la misma protección utilizando el trait \ZfMetal\SecurityJwt\Controller\Traits\TraitProtectedController