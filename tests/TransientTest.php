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

test('constants', function ()
{
    expect(rex_transient::minutes(1))->toEqual(60);
    expect(rex_transient::minutes(2))->toEqual(120);
    expect(rex_transient::hours(1))->toEqual(3600);
    expect(rex_transient::hours(2))->toEqual(7200);
    expect(rex_transient::days(1))->toEqual(86400);
    expect(rex_transient::days(2))->toEqual(172800);
});

test('helpers', function ()
{
    expect(rex_transient::MINUTE_IN_SECONDS)->toEqual(60);
    expect(rex_transient::HOUR_IN_SECONDS )->toEqual(3600);
    expect(rex_transient::DAY_IN_SECONDS )->toEqual(86400);
});

afterEach(function ()
{
    rex_transient::remove($this->namespace, $this->key);
});
