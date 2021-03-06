describe('InPropertiesItemFilter', function() {
    var in_properties_filter,
        list = [{
            label      : 'Riri',
            id         : 'nephew',
            card_fields: []
        }, {
            label      : 'Fifi',
            id         : 'nephew',
            card_fields: []
        }, {
            label      : 'Loulou',
            id         : 'nephew',
            card_fields: []
        }, {
            label            : 'Donald',
            id               : 'uncle',
            card_fields      : [],
            internal_property: 'has nephews'
        }, {
            label      : 'Donald & Daisy',
            id         : 'significant others',
            card_fields: []
        }];

    beforeEach(function() {
        module('kanban');

        var $filter, moment;
        inject(function(
            _$filter_,
            _moment_
        ) {
            $filter = _$filter_;
            moment  = _moment_;
        });

        in_properties_filter = $filter('InPropertiesFilter');
        (moment.locale || moment.lang)('en');
    });

    it('has a InPropertiesFilter filter', function() {
        expect(in_properties_filter).not.toBeNull();
    });

    it('filters on label', function() {
        expect(in_properties_filter(list, 'Donald')).toContain({
            label            : 'Donald',
            id               : 'uncle',
            card_fields      : [],
            internal_property: 'has nephews'
        });
        expect(in_properties_filter(list, 'Donald')).toContain({
            label      : 'Donald & Daisy',
            id         : 'significant others',
            card_fields: []
        });
        expect(in_properties_filter(list, 'Donald')).not.toContain({
            label      : 'Riri',
            id         : 'nephew',
            card_fields: []
        });
    });

    it('is case insensitive', function() {
        expect(in_properties_filter(list, 'RIRI')).toContain({
            label      : 'Riri',
            id         : 'nephew',
            card_fields: []
        });
    });

    it('filters on id', function() {
        expect(in_properties_filter(list, 'nephew')).toContain({
            label      : 'Riri',
            id         : 'nephew',
            card_fields: []
        });
        expect(in_properties_filter(list, 'nephew')).toContain({
            label      : 'Fifi',
            id         : 'nephew',
            card_fields: []
        });
        expect(in_properties_filter(list, 'nephew')).toContain({
            label      : 'Loulou',
            id         : 'nephew',
            card_fields: []
        });
        expect(in_properties_filter(list, 'nephew')).not.toContain({
            label      : 'Donald & Daisy',
            id         : 'significant others',
            card_fields: []
        });
    });

    it('does not filter on private properties', function() {
        expect(in_properties_filter(list, 'nephew')).not.toContain({
            label            : 'Donald',
            id               : 'uncle',
            card_fields      : [],
            internal_property: 'has nephews'
        });
    });

    it('filters on both label and id', function() {
        expect(in_properties_filter(list, 'nephew riri')).toContain({
            label      : 'Riri',
            id         : 'nephew',
            card_fields: []
        });
    });

    it('returns items that match all criteria', function() {
        expect(in_properties_filter(list, 'donald daisy')).toContain({
            label      : 'Donald & Daisy',
            id         : 'significant others',
            card_fields: []
        });
        expect(in_properties_filter(list, 'donald daisy')).not.toContain({
            label            : 'Donald',
            id               : 'uncle',
            card_fields      : [],
            internal_property: 'has nephews'
        });
        expect(in_properties_filter(list, 'daisy donald')).toContain({
            label      : 'Donald & Daisy',
            id         : 'significant others',
            card_fields: []
        });
        expect(in_properties_filter(list, 'daisy donald')).not.toContain({
            label            : 'Donald',
            id               : 'uncle',
            card_fields      : [],
            internal_property: 'has nephews'
        });
    });

    it('returns items that have matching card_fields', function() {
        expect(in_properties_filter([{
            id         : null,
            label      : null,
            card_fields: [{
                type : 'string',
                value: 'Histoire de Toto'
            }]
        }], 'toto').length).toBe(1);
        expect(in_properties_filter([{
            id         : null,
            label      : null,
            card_fields: [{
                type : 'text',
                value: 'Histoire de Toto'
            }]
        }], 'toto').length).toBe(1);
        expect(in_properties_filter([{
            id         : null,
            label      : null,
            card_fields: [{
                type : 'int',
                value: 123
            }]
        }], '123').length).toBe(1);
        expect(in_properties_filter([{
            id         : null,
            label      : null,
            card_fields: [{
                type : 'float',
                value: 3.14
            }]
        }], '3.14').length).toBe(1);
        expect(in_properties_filter([{
            id         : null,
            label      : null,
            card_fields: [{
                type : 'aid',
                value: 42
            }]
        }], '42').length).toBe(1);
        expect(in_properties_filter([{
            id         : null,
            label      : null,
            card_fields: [{
                type : 'atid',
                value: 42
            }]
        }], '42').length).toBe(1);
        expect(in_properties_filter([{
            id         : null,
            label      : null,
            card_fields: [{
                type : 'computed',
                value: 42
            }]
        }], '42').length).toBe(1);
        expect(in_properties_filter([{
            id         : null,
            label      : null,
            card_fields: [{
                type : 'priority',
                value: 42
            }]
        }], '42').length).toBe(1);
        expect(in_properties_filter([{
            id         : null,
            label      : null,
            card_fields: [{
                type             : 'file',
                file_descriptions: [{
                    name: 'Photo de Toto.png'
                }]
            }]
        }], 'toto').length).toBe(1);
        expect(in_properties_filter([{
            id         : null,
            label      : null,
            card_fields: [{
                type : 'cross',
                value: [{
                    ref: 'release #42'
                }]
            }]
        }], '42').length).toBe(1);
        expect(in_properties_filter([{
            id         : null,
            label      : null,
            card_fields: [{
                type          : 'perm',
                granted_groups: ['toto']
            }]
        }], 'toto').length).toBe(1);
        expect(in_properties_filter([{
            id         : null,
            label      : null,
            card_fields: [{
                type : 'subby',
                value: {
                    display_name: 'Mr Toto'
                }
            }]
        }], 'toto').length).toBe(1);
        expect(in_properties_filter([{
            id         : null,
            label      : null,
            card_fields: [{
                type : 'luby',
                value: {
                    display_name: 'Mr Pototo'
                }
            }]
        }], 'toto').length).toBe(1);
        ['sb', 'rb', 'cb', 'msb', 'tbl', 'shared'].forEach(function(list_type) {
            expect(in_properties_filter([{
                id         : null,
                label      : null,
                card_fields: [{
                    type  : list_type,
                    values: [{
                        label: 'Reopen'
                    }]
                }]
            }], 'open').length).toBe(1);
            expect(in_properties_filter([{
                id         : null,
                label      : null,
                card_fields: [{
                    type  : list_type,
                    values: [{
                        display_name: 'Mr Toto'
                    }]
                }]
            }], 'toto').length).toBe(1);
        });
        ['date', 'lud', 'subon'].forEach(function(date_type) {
            var today = new Date();

            expect(in_properties_filter([{
                id         : null,
                label      : null,
                card_fields: [{
                    type : date_type,
                    value: today.toJSON()
                }]
            }], 'today').length).toBe(1);
        });
    });

    it("Given no terms to filter with, when I filter a list of items, then a copy of this list with the same items will be returned", function() {
        var list = [
            { id: 28 },
            { id: 94 },
            { id: 69 }
        ];

        var filtered_list = in_properties_filter(list, '');

        expect(filtered_list).toEqual(list);
        expect(filtered_list).not.toBe(list);
    });
});
