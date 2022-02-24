<?php

use App\Domain\User\ValueObjects\Role;

test('should throw exception if role is not valid', function () {
    new Role('invalid');
})->throws(InvalidArgumentException::class);

test('should return value if role is valid', function () {
    $roleValue = 'admin';
    $role = new Role($roleValue);
    expect($role)->toEqual($roleValue);
});

test('should return true in isAdmin if user is admin', function () {
    $role = new Role('admin');
    expect($role->isAdmin())->toEqual(true);
});

test('should return false in isAdmin if user is not admin', function () {
    $role = new Role('student');
    expect($role->isAdmin())->toEqual(false);
});

test('should return true in isStudent if user is student', function () {
    $role = new Role('student');
    expect($role->isStudent())->toEqual(true);
});

test('should return false in isStudent if user is not student', function () {
    $role = new Role('teacher');
    expect($role->isStudent())->toEqual(false);
});

test('should return true in isTeacher if user is teacher', function () {
    $role = new Role('teacher');
    expect($role->isTeacher())->toEqual(true);
});

test('should return false in isTeacher if user is not teacher', function () {
    $role = new Role('student');
    expect($role->isTeacher())->toEqual(false);
});