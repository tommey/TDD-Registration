<?php
/**
 * @startuml
 * class User {
 *     +email: string
 *     +password: string
 * }
 * class Validator {
 *     +validateUser($user): bool
 *     +validateEmail($email): bool
 *     +validatePassword($password): bool
 * }
 * class Fraud {
 * }
 * class Email {
 * }
 * class Password {
 * }
 * class EncodedPassword {
 * }
 * class PasswordGenerator {
 * 	+generate(): Password
 * }
 * class RegistrationModule {
 * 	+register($email, $password)
 *  +registerExternal($email, $provider)
 * }
 * @enduml
 */
