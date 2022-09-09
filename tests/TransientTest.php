<?php

beforeEach(function ()
{
    $uid = uniqid('unittest', false);

    $this->namespace = $uid;
    $this->key = $uid;
    $this->value = 'value';
});

test('expect transient to be a string', function ()
{
    rex_transient::set($this->namespace, $this->key, $this->value, 60);
    $data = rex_transient::get($this->namespace, $this->key);

    expect($data)->toBeString();
});

test('expect transient to be null', function ()
{
    $data = rex_transient::get('test-ns', 'mykey');

    expect($data)->toBeNull();
});

test('expect transient to be removed', function ()
{
    $key = $this->key . '_rm';

    rex_transient::set($this->namespace, $key, $this->value, 60);
    $data = rex_transient::get($this->namespace, $key);

    expect($data)->toBeString();

    rex_transient::remove($this->namespace, $key);
    $data = rex_transient::get($this->namespace, $key);

    expect($data)->toBeNull();
});

afterEach(function ()
{
    rex_transient::remove($this->namespace, $this->key);
});
